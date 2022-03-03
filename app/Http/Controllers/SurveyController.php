<?php

namespace App\Http\Controllers;

use App\Exports\SurveyExport;
use App\Http\Requests\StoreSurveyAnswerRequest;
use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyDetails;
use App\Http\Resources\SurveyResource;
use App\Models\Client;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return SurveyResource::collection(Survey::where('user_id', $user->id)->paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }
        $result = Survey::create($data);
        foreach ($data['questions'] as  $question) {
            $question['survey_id'] = $result->id;
            $this->createQuestion($question);
        }
        return new SurveyResource($result);
    }
    public function storeAnswer(StoreSurveyAnswerRequest $request, Survey $survey)
    {
        $validated = $request->validated();
        $surveyAnswer = SurveyAnswer::create([
            'survey_id' => $survey->id,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
        ]);
        foreach ($validated['answers'] as $questionId => $answer) {
            $question = SurveyQuestion::where(['id' => $questionId, 'survey_id' => $survey->id])->get();
            if (!$question) {
                return response("Invalid question ID: \"$questionId\"", 400);
            }
            $data = [
                'survey_question_id' => $questionId,
                'survey_answer_id' => $surveyAnswer->id,
                'answer' => is_array($answer) ?  json_encode($answer) : $answer,
            ];
            SurveyQuestionAnswer::create($data);
        }
        return response("", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403, 'Unauthorized action');
        }
        return new SurveyResource($survey);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSurveyRequest  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
            if ($survey->image) {
                $absolutePath = public_path('images/', $survey->image);
                File::delete($absolutePath);
            }
        }
        $survey->update($data);
        // get ids as plain array of existing questions
        $existingIds = $survey->questions()->pluck('id')->toArray();
        // get ids as plain array of new questions
        $newIds = Arr::pluck($data['questions'], 'id');
        // find questions to delete
        $toDelete = array_diff($existingIds, $newIds);
        // find questions to add
        $toAdd = array_diff($newIds, $existingIds);
        // delete qstns bu toDelete array
        SurveyQuestion::destroy($toDelete);
        // create new qstns
        foreach ($data['questions'] as $key => $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['survey_id'] = $survey->id;
                $this->createQuestion($question);
            }
        }
        // update existing qstn
        $questionMap = collect($data['questions'])->keyBy('id');
        foreach ($survey->questions as   $question) {
            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }
        return new SurveyResource($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403, 'Unauthorized action');
        }
        $survey->delete();
        if ($survey->image) {
            $absolutePath = public_path('images/', $survey->image);
            File::delete($absolutePath);
        }
        return response('', 204);
    }
    private function saveImage($image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['png', 'jpeg', 'gif', 'jpg'])) {
                throw new \Exception("invalid image type");
            }
            $image = str_replace('', '+', $image);
            $image = base64_decode($image);
            if ($image === false) {
                throw new \Exception("base64 decode failed");
            }
        } else {
            throw new \Exception("did not match data URI with image data");
        }
        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
    private function createQuestion($data)
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'question' => 'required|string',
            'type' => ['required', Rule::in(
                [
                    Survey::TYPE_TEXT,
                    Survey::TYPE_TEXTAREA,
                    Survey::TYPE_RADIO,
                    Survey::TYPE_SELECT,
                    Survey::TYPE_CHECKBOX,
                ]
            )],
            'description' => 'nullable|String',
            'data' => 'present',
            'survey_id' => 'exists:App\Models\Survey,id'
        ]);
        return SurveyQuestion::create($validator->validated());
    }
    private function updateQuestion(SurveyQuestion $question, $data)
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'id' => 'exists:App\Models\SurveyQuestion,id',
            'question' => 'required|string',
            'type' => ['required', Rule::in(
                [
                    Survey::TYPE_TEXT,
                    Survey::TYPE_TEXTAREA,
                    Survey::TYPE_RADIO,
                    Survey::TYPE_SELECT,
                    Survey::TYPE_CHECKBOX,
                ]
            )],
            'description' => 'nullable|String',
            'data' => 'present',
            'survey_id' => 'exists:App\Models\Survey,id'
        ]);
        return $question->update($validator->validated());
    }
    public function showForGuest(Survey $survey)
    {

        return new SurveyResource($survey);
    }

    public function excellExport()
    {
        return Excel::download(new SurveyExport(), 'survey.xlsx');
    }
    public function SurveyDetails(Request $request)
    {
        $surveyData = [];
        $user = $request->user();
        $survey = Survey::query()->where('user_id', $user->id)->first();
        $survey->image = $survey->image ? URL::to($survey->image) : null;
        $client = Client::where('id', $survey->client_id)->first();
        $survey->client_id = $client->name;
        $employe = Client::where('id', $survey->employe_id)->first();
        $survey->employe_id = $employe->name;
        $answers = SurveyAnswer::where('survey_id', $survey->id)->get();
        $surs = [];
        $ans = [];
        $i = 0;
        foreach ($answers as $key => $answer) {
            foreach (SurveyQuestionAnswer::where('survey_answer_id', $answer->id)->get() as $keys => $ques) {
                $data =  [
                    'start_date' => $answer->start_date,
                    'question' => SurveyQuestion::where('id', $ques->survey_question_id)->first(),
                    'answer' => $ques->answer
                ];
                $surveyData[$i] = $data;
                $i++;
            }
        }
        return response()->json([
            'survey' => $survey,  'ans' => $surveyData
        ]);
    }
}
