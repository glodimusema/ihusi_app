import axios from 'axios'
import { isNull } from "lodash"
const state = {
    depositAmount: [],
    memberPercent:[],
    cashDeskAmount:0,
    apiBaseURL: window.emerfine.apiBaseURL,
    isLoading: false,
    categoryList:[],
    advantageList:[],
    retenueList:[],
    serviceList:[],
    divisionList:[],
    agentList:[],
    // mes scripts
    userList:[],
    userListAll:[],
    roleList:[],
    siteList:[],
    memberList:[],
    basicList:[],
    memberReunionList: [],
    memberListContribution: [],
    contributionList:[],

    memberCreditList:[],
    remboursementList:[],
    categoryArticleList:[],

    //PNUD
    id_entreprise:"",
    paysList:[],
    provinceList:[],
    user2List:[],
    formeJuridiqueList:[],
    secteurList:[],
    projectDetail: "",
    AllservicesArticleList:[],

    //liste des editions
    ListeEdition: [
        { designation: '2021', text: 'Année 2021' },
        { designation: '2022', text: 'Année 2022'  },
        { designation: '2023', text: 'Année 2023'  },
        { designation: '2024', text: 'Année 2024'  },
        { designation: '2025', text: 'Année 2025'  },
        { designation: '2026', text: 'Année 2026'  },
        { designation: '2027', text: 'Année 2027'  },
        { designation: '2028', text: 'Année 2028'  },
        { designation: '2029', text: 'Année 2029'  },
        { designation: '2030', text: 'Année 2030'  },
    ],

    ListeNBREmploye: [
        { designation: '1-5', text: '1-5 employés' },
        { designation: '5-10', text: '5-10 employés'  },
        { designation: '10-15', text: '10-15 employés'  },
        { designation: '15-20', text: '15-20 employés'  },
        { designation: '20-25', text: '20-25 employés'  },
        { designation: '25-100', text: '25-100 employés'  },
        
    ],

    ListeTitreCanvas: [
        { designation: 'Problème' },
        { designation: 'Solution' },
        { designation: 'Proposition de valeur unique' },
        { designation: 'Avantage déloyale' },
        { designation: 'Segment de client' },
        { designation: 'Indicateur' },
        { designation: 'Canaux' },
        { designation: 'Structure des coûts' },
        { designation: 'Sources revenus' },
        
    ],
    ListeTitreSwot: [
        { designation: 'Forces' },
        { designation: 'Faiblesses' },
        { designation: 'Opportunités' },
        { designation: 'Menaces' },
        
    ],

    ListeTerritoire: [
        { designation: 'Mwenga' },
        { designation: 'Pangi' },
        { designation: 'Shabunda' },
        { designation: 'Walikale' },
        
    ],





    userType: isNull(window.emerfine.user) ? 'null' : window.emerfine.user.user_type,
}

const getters = {
    depositAmount: state => state.depositAmount,
    cashDeskAmount:state=>state.cashDeskAmount,
    memberPercent:state=>state.memberPercent,
    isloading: (state) => (state.isLoading),
    categoryList:(state)=>(state.categoryList),
    advantageList:(state)=>(state.advantageList),
    retenueList:(state)=>(state.retenueList),
    serviceList:(state)=>(state.serviceList),
    divisionList:(state)=>(state.divisionList),
    agentList:(state)=>(state.agentList),

    // mes scripts
    userList:(state)=>(state.userList),
    userListAll:(state)=>(state.userListAll),
    
    roleList:(state)=>(state.roleList),
    siteList:(state)=>(state.siteList),
    memberList:(state)=>(state.memberList),
    basicList:(state)=>(state.basicList),
    reunionList:(state)=>(state.reunionList),

    memberReunionList:(state)=>(state.memberReunionList),

    memberListContribution:(state)=>(state.memberListContribution),
    contributionList:(state)=>(state.contributionList),
    memberCreditList:(state)=>(state.memberCreditList),
    remboursementList:(state)=>(state.remboursementList),


    //PNUD assurence
    ListeEdition: (state) => state.ListeEdition,
    ListeNBREmploye: (state) => state.ListeNBREmploye,
    ListeTitreCanvas: (state) => state.ListeTitreCanvas,
    ListeTitreSwot: (state) => state.ListeTitreSwot,
    ListeTerritoire: (state) => state.ListeTerritoire,

    id_entreprise: (state) => state.id_entreprise,    

    paysList:(state)=>(state.paysList),
    provinceList:(state)=>(state.provinceList),
    formeJuridiqueList:(state)=>(state.formeJuridiqueList),
    secteurList:(state)=>(state.secteurList),
    user2List:(state)=>(state.user2List),

    projectDetail: (state) => state.projectDetail,

    categoryArticleList:(state)=>(state.categoryArticleList),
    AllservicesArticleList:(state)=>(state.AllservicesArticleList),
    
    
    
    
    

}

const actions = {

    async getAgent({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name`)
            .then(({ data }) => {
                commit('SET_AGENT', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getDivision({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_division`)
            .then(({ data }) => {
                commit('SET_DIVISION', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },
    async getService({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_service`)
            .then(({ data }) => {
                commit('SET_SERVICES', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getRetenu({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_retenu`)
            .then(({ data }) => {
                commit('SET_RETENU', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getAdvantages({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_advantage`)
            .then(({ data }) => {
                commit('SET_ADVANTAGES', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getCategory({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_categories`)
            .then(({ data }) => {
                commit('SET_CATEGORIES', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberPercent({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_percents`)
            .then(({ data }) => {
                commit('SET_MEMBER_PERCENT', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getDepositAmount({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/desposit_amount`)
            .then(({ data }) => {
                commit('SET_DEPOSIT_AMOUNT', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },
    async getCashDesk({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_amount`)
            .then(({ data }) => {
                commit('SET_CASH_DESK', data.data[0].amount)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    //mes scripts
    async getUser({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_user`)
            .then(({ data }) => {
                commit('SET_USER', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },
//
    async getUser2({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_user_all`)
            .then(({ data }) => {
                commit('SET_USER', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    

    async getRole({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_role`)
            .then(({ data }) => {
                commit('SET_ROLE', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getSite({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_site`)
            .then(({ data }) => {
                commit('SET_SITE', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMember({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name`)
            .then(({ data }) => {
                commit('SET_MEMBER', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getBasic({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_basic`)
            .then(({ data }) => {
                commit('SET_BASIC', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getReunion({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_reunion`)
            .then(({ data }) => {
                commit('SET_REUNION', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberReunion({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name_reunion`)
            .then(({ data }) => {
                commit('SET_MEMBER_REUNION', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberListContribution({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name_contributeur`)
            .then(({ data }) => {
                commit('SET_MEMBER_LIST_CONTRIBUTION', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getContribution({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_contribution`)
            .then(({ data }) => {
                commit('SET_CONTRIBUTION', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberListCredit({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name_credit`)
            .then(({ data }) => {
                commit('SET_MEMBER_LIST_CREDIT', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getRemboursement({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_remboursement`)
            .then(({ data }) => {
                commit('SET_REMBOURSEMENT', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },


    //PNUD assurence
    async getPays({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_pays_2`)
            .then(({ data }) => {
                commit('SET_PAYS', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getProvince({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_province_2`)
            .then(({ data }) => {
                commit('SET_PROVINCE', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getFormejuridique({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_forme_juridiques_2`)
            .then(({ data }) => {
                commit('SET_FORMEJURIDIQUE', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getSecteurList({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_secteur_2`)
            .then(({ data }) => {
                commit('SET_SECTEUR', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getProjectInfos({ commit }, slug) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/get_project_infos/${slug}`)
            .then(({ data }) => {
                commit("GET_PROJECT_DETAIL", data.projectDetail);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },
    async getCategyArticle({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetchCategoryArticle`)
            .then(({ data }) => {
                commit('SET_CATEGORYARTICLE', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getUserAll({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_user_all`)
            .then(({ data }) => {
                commit('SET_USER_All', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getAllServices({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_ours_services`)
            .then(({ data }) => {
                commit('SET_ALLSERVICES', data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },




}
//update data
const mutations = {
    SET_LOADING_STATUS: (state) => (state.isLoading = !state.isLoading),
    SET_DEPOSIT_AMOUNT: (state, depositAmount) => (state.depositAmount = depositAmount),
    SET_CASH_DESK:(state,cashDeskAmount)=>(state.cashDeskAmount=cashDeskAmount),
    SET_MEMBER_PERCENT:(state,memberPercent)=>(state.memberPercent=memberPercent),

    SET_CATEGORIES:(state,categoryList)=>(state.categoryList=categoryList),
    SET_ADVANTAGES:(state,advantageList)=>(state.advantageList=advantageList),
    SET_RETENU:(state,retenueList)=>(state.retenueList=retenueList),
    SET_SERVICES:(state,serviceList)=>(state.serviceList=serviceList),
    SET_DIVISION:(state,divisionList)=>(state.divisionList=divisionList),
    SET_AGENT:(state,agentList)=>(state.agentList=agentList),

    //mes scripts
    SET_USER:(state,userList)=>(state.userList=userList),
    SET_ROLE:(state,roleList)=>(state.roleList=roleList),
    SET_SITE:(state,siteList)=>(state.siteList=siteList),
    SET_MEMBER:(state,memberList)=>(state.memberList=memberList),
    SET_BASIC:(state,basicList)=>(state.basicList=basicList),
    SET_REUNION:(state,reunionList)=>(state.reunionList=reunionList),
    SET_MEMBER_REUNION:(state,memberReunionList)=>(state.memberReunionList=memberReunionList),

    SET_MEMBER_LIST_CONTRIBUTION:(state,memberListContribution)=>(state.memberListContribution=memberListContribution),
    SET_CONTRIBUTION:(state,contributionList)=>(state.contributionList=contributionList),
    
    SET_MEMBER_LIST_CREDIT:(state,memberCreditList)=>(state.memberCreditList=memberCreditList),
    SET_REMBOURSEMENT:(state,remboursementList)=>(state.remboursementList=remboursementList),


    //PNUD assurence
    SET_PAYS:(state,paysList)=>(state.paysList=paysList),
    SET_PROVINCE:(state,provinceList)=>(state.provinceList=provinceList),
    SET_USER_2:(state,user2List)=>(state.user2List=user2List),
    SET_FORMEJURIDIQUE:(state,formeJuridiqueList)=>(state.formeJuridiqueList=formeJuridiqueList),
    SET_SECTEUR:(state,secteurList)=>(state.secteurList=secteurList),

    GET_PROJECT_DETAIL: (state, projectDetail) =>
        (state.projectDetail = projectDetail),

    SET_CATEGORYARTICLE:(state,categoryArticleList)=>(state.categoryArticleList=categoryArticleList),
    SET_USER_All:(state,userListAll)=>(state.userListAll=userListAll),

    SET_ALLSERVICES:(state,AllservicesArticleList)=>(state.AllservicesArticleList=AllservicesArticleList),
    
    



}

export default {
    state,
    getters,
    actions,
    mutations
}