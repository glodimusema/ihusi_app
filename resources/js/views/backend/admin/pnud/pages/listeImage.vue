<template>
    
    <div>
       
        <v-card
            :loading="loading"
            class="mx-auto my-0"

        >
           

            <v-card-text>
           
                <div class="block galleryBlock">
                    <v-container>
                    
                        <v-row>

                            <v-col v-for="item in fetchData" :key="item.id" class="d-flex child-flex" cols="6" sm="4">
                                <v-card flat tile class="d-flex">
                                    <!-- <v-avatar
                                        size="avatarSize"
                                        color="red"
                                    >
                                        <img 
                                            :src="item.photo== null || item.photo==''
                                            ? `${baseURL}/images/avatar.png`
                                            : `${baseURL}/documents/images/` + item.photo
                                        " 
                                         alt="alt">
                                         
                                       
                                    </v-avatar> -->

                                    <v-avatar
                                        tile 
                                        size="195"
                                        color="blue lighten-5"
                                        @dblclick="clearP(item.id)"
                                    >
                                        <img 
                                            :src="item.photo== null || item.photo==''
                                            ? `${baseURL}/images/avatar.png`
                                            : `${baseURL}/documents/images/` + item.photo
                                        " 
                                         alt="alt">
                                    </v-avatar>
                                   
                                   
                                    
                                </v-card>
                            </v-col> 
                             
                        </v-row>
                        <v-row>

                            <v-col class="d-flex child-flex" cols="12" sm="12">
                                <div class="mt-2 text-center">
                                    <v-pagination
                                        color="primary"
                                        v-model="pagination.current"
                                        :length="pagination.total"
                                        :total-visible="0"
                                        @input="onPageChange"
                                    ></v-pagination>
                                </div>
                            </v-col>   

                        </v-row>
                    </v-container>
                </div>
            
            </v-card-text>

           
        </v-card>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    components:{
    },
    data(){
        return{
            title:"Liste image",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            selection: 0,

          

            fetchData: null,
            query:"",
        }

    },
    created(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);
        this.onPageChange();
    },
    computed: {
        ...mapGetters([
            "projectDetail",
            "isloading",
            "paysList",
            "provinceList",
            "user2List",
            "formeJuridiqueList",
            "secteurList",
            "ListeEdition",
            "ListeNBREmploye",
            
        ]),
    },
    methods:{
        ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList"
        ]),
        reserve () {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            var slug = this.$route.params.slug;
            this.fetch_data(`${this.apiBaseURL}/fetch_photo_entreprise/${slug}?page=`);
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_photo_entreprise/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

    },

}
</script>
<style scoped>
.link_pro{
    text-decoration: none;
}
</style>

