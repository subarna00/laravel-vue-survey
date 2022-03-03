import { createStore } from "vuex";
import axiosClient from "../axios";
const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
        dashboard: {
            loading: false,
            data: {},
        },
        currentSurvey: {
            loading: false,
            data: {},
        },
        surveyDetails: {
            loading: false,
            surveyData: {
                survey: [],
                answers: [],
            },
        },
        surveys: {
            loading: false,
            links: [],
            data: [],
        },
        employes: {
            loading: false,
            data: [],
        },
        currentEmploye: {
            loading: false,
            data: [],
        },
        clients: {
            loading: false,
            data: [],
        },
        currentClient: {
            loading: false,
            data: [],
        },
        questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
        notification: {
            show: false,
            type: null,
            message: null,
        },
        QuestionAnswer: {
            loading: false,
            data: [],
        },
    },
    getters: {},
    actions: {
        getDashboardData: ({ commit }) => {
            commit("dashboardLoading", true);
            return axiosClient
                .get("/dashboard")
                .then((res) => {
                    commit("dashboardLoading", false);
                    commit("setDashboardData", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("dashboardLoading", false);
                    return err;
                });
        },
        getSurveys: ({ commit }, { url = null } = {}) => {
            url = url || "/surveys";
            commit("setSurveysLoading", true);
            return axiosClient.get(url).then((res) => {
                commit("setSurveysLoading", false);
                commit("setSurveys", res.data);
                return res;
            });
        },
        getSurvey({ commit }, survey) {
            console.log(survey);
            commit("setCurrentSurveyLoading", true);
            return axiosClient
                .get(`/surveys/${survey}`)
                .then((res) => {
                    commit("setCurrentSurvey", res.data);
                    commit("setCurrentSurveyLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSurveyLoading", false);
                    throw err;
                });
        },
        saveSurvey({ commit }, survey) {
            delete survey.image_url;
            let response;
            if (survey.id) {
                response = axiosClient
                    .put(`/surveys/${survey.id}`, survey)
                    .then((res) => {
                        commit("setCurrentSurvey", res.data);
                        return res;
                    });
            } else {
                response = axiosClient.post("/surveys", survey).then((res) => {
                    commit("setCurrentSurvey", res.data);
                    return res;
                });
            }
            return response;
        },
        register({ commit }, user) {
            return axiosClient.post("/register", user).then(({ data }) => {
                commit("setUser", data);
                return data;
            });
        },
        login({ commit }, user) {
            return axiosClient.post("/login", user).then(({ data }) => {
                commit("setUser", data);
                return data;
            });
        },
        logout({ commit }) {
            return axiosClient.get("/logout").then((response) => {
                commit("logout");
                return response;
            });
        },
        deleteSurvey({ commit }, id) {
            return axiosClient.delete(`/surveys/${id}`);
        },
        getSurveyBySlug: ({ commit }, slug) => {
            commit("setCurrentSurveyLoading", true);
            return axiosClient
                .get(`/survey-by-slug/${slug}`)
                .then((res) => {
                    commit("setCurrentSurvey", res.data);
                    commit("setCurrentSurveyLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSurveyLoading", false);
                    throw err;
                });
        },
        getSurveyDetail: ({ commit }, id) => {
            return axiosClient
                .get(`/survey-details/${id}`)
                .then((res) => {
                    commit("setSurveyDetails", res.data);
                    return res;
                })
                .catch((err) => {
                    return err;
                });
        },
        saveSurveyAnswer: ({ commit }, { surveyId, answers }) => {
            return axiosClient.post(`/survey/${surveyId}/answer`, { answers });
        },
        getEmployes: ({ commit }) => {
            commit("setEmployeLoading", true);
            return axiosClient
                .get("/employe")
                .then((res) => {
                    commit("setEmployeLoading", false);
                    commit("setEmployes", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setEmployeLoading", false);
                    return err;
                });
        },
        saveEmploye: ({ commit }, employe) => {
            delete employe.profile_picture_url;
            let response;
            if (employe.id) {
                response = axiosClient
                    .put(`/employe/${employe.id}`, employe)
                    .then((res) => {
                        return res;
                    })
                    .catch((err) => {
                        return err;
                    });
            } else {
                response = axiosClient
                    .post("/employe", employe)
                    .catch((err) => {
                        console.log(err);
                        return err;
                    });
            }
            return response;
        },
        deleteEmploye: ({ commit }, id) => {
            return axiosClient.delete(`/employe/${id}`);
        },
        getCurrentEmploye: ({ commit }, id) => {
            return axiosClient
                .get(`/employe/${id}`)
                .then((res) => {
                    commit("setCurrentEmployeLoading", true);
                    commit("setCurrentEmploye", res.data);
                    console.log(res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentEmployeLoading", false);
                    return err;
                });
        },
        getClients: ({ commit }) => {
            return axiosClient
                .get("/client")
                .then((res) => {
                    commit("setClients", res.data);
                    return res;
                })
                .catch((err) => {
                    return err;
                });
        },
        saveClient: ({ commit }, client) => {
            delete client.image_url;
            let response;
            if (client.id) {
                response = axiosClient
                    .put(`/client/${client.id}`, client)
                    .then((res) => {
                        return res;
                    })
                    .catch((err) => {
                        return err;
                    });
            } else {
                response = axiosClient
                    .post("/client", client)
                    .then((res) => {
                        return res;
                    })
                    .catch((err) => {
                        return err;
                    });
            }
        },
        deleteClient: ({ commit }, id) => {
            return axiosClient
                .delete(`/client/${id}`)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err;
                });
        },
        getCurrentClient: ({ commit }, id) => {
            return axiosClient
                .get(`/client/${id}`)
                .then((res) => {
                    commit("setCurrentClient", res.data);
                    return res;
                })
                .catch((err) => {
                    return err;
                });
        },
        surveyExcellDownload: ({ commit }) => {
            return axiosClient
                .get("/survey/export", {
                    responseType: "arraybuffer",
                })
                .then((response) => {
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement("a");
                    fileLink.href = fileURL;
                    fileLink.setAttribute("download", "test.xlsx");
                    document.body.appendChild(fileLink);
                    fileLink.click();
                });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem("TOKEN");
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem("TOKEN", userData.token);
        },
        setCurrentSurveyLoading: (state, loading) => {
            state.currentSurvey.loading = loading;
        },
        setSurveysLoading: (state, loading) => {
            state.surveys.loading = loading;
        },
        setCurrentSurvey: (state, survey) => {
            state.currentSurvey.data = survey.data;
        },
        setSurveys: (state, surveys) => {
            state.surveys.links = surveys.meta.links;
            state.surveys.data = surveys.data;
        },
        notify: (state, { message, type }) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
                state.notification.show = false;
            }, 3000);
        },
        dashboardLoading: (state, loading) => {
            state.dashboard.loading = loading;
        },
        setDashboardData: (state, data) => {
            state.dashboard.data = data;
        },
        setEmployeLoading: (state, loading) => {
            state.employes.loading = loading;
        },
        setEmployes: (state, data) => {
            state.employes.data = data.data;
        },
        setCurrentEmployeLoading: (state, loading) => {
            state.currentEmploye.loading = loading;
        },
        setCurrentEmploye: (state, data) => {
            state.currentEmploye.data = data.data;
        },
        setClients: (state, data) => {
            state.clients.data = data.data;
        },
        setCurrentClient: (state, data) => {
            state.currentClient.data = data.data;
        },
        setSurveyDetails: (state, datas) => {
            let data = [];
            let jsonData = datas.ans;
            let first = datas.ans[0];
            let tempDate = first.start_date;
            let curObj = {
                start_date: first["start_date"],
                detail: [
                    {
                        question: { ...first.question },
                        answer: first.answer,
                    },
                ],
            };

            for (let i = 1; i < jsonData.length; ++i) {
                let curr = jsonData[i];
                if (tempDate === curr.start_date) {
                    let tempDetail = {
                        question: { ...curr.question },
                        answer: curr.answer,
                    };
                    curObj.detail.push(tempDetail);
                    continue;
                }
                data.push(curObj);
                tempDate = curr.start_date;
                curObj = {
                    start_date: curr["start_date"],
                    detail: [
                        {
                            question: { ...curr.question },
                            answer: curr.answer,
                        },
                    ],
                };
            }
            data.push(curObj);

            console.log(data);

            // console.log(data.ans[0]);
            state.surveyDetails.surveyData.survey = datas.survey;
            state.surveyDetails.surveyData.answers = data;
        },
        getAnswerQuestion: (state, ans) => {
            state.QuestionAnswer.data = ans;
        },
    },
    modules: {},
});
export default store;
