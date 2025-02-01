<template>
    <div >
        <v-card-actions v-for="(item, index) in list" :key="index">

            <a 
            text 
            link 
            :href="
                item.Pitch_list[0].pitch == null
                ? `${baseURL}/documents/logo.png`
                : `${baseURL}/documents/` + item.Pitch_list[0].pitch
            " 
            
            class="btn btn-primary mr-1"  
            color="deep-purple lighten-2" 
            style="text-decoration: none;"
            >
                 <v-icon color="primary" class="mr-1">file_download</v-icon>Son  Pitch  
            </a>

            <a 
            text 
            link 
            :href="
                item.Document_list[0].busness_plan == null
                ? `${baseURL}/documents/logo.png`
                : `${baseURL}/documents/` + item.Document_list[0].busness_plan
            " 
             
            class="btn btn-primary mr-1"  
            color="deep-purple lighten-2" 
            style="text-decoration: none;"
            >
                <v-icon color="primary" class="mr-1">file_download</v-icon> Ses Documents
            </a>

          
        </v-card-actions>
        
        
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data(){
        return{
            title: "Les documents",
            list: [],

        }
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

        getInfoDocumentTOdownload(){
            var slug = this.$route.params.slug;
            this.editOrFetch(`${this.apiBaseURL}/get_project_infos_document/${slug}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.list = donnees;
     
                }
            );
        }

    },
    created(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);
        this.getInfoDocumentTOdownload();
    },
}
</script>

<style scoped>


.btn {
  display: inline-block;
  font-weight: 400;
  color: #212529;
  text-align: center;
  vertical-align: middle;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  background-color: transparent;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 0.9rem;
  line-height: 1.6;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-primary {
  color: blue;
  border-color: #3490dc;
}

</style>

