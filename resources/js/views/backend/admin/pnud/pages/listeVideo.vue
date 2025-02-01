<template>
    
    <div>

         <v-flex md12>
      <v-dialog
        v-model="dialog"
        max-width="600"
        hide-overlay
        transition="dialog-bottom-transition"
        persistent
      >
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title class="text-h6 primary">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip></v-card-title
            >
            <v-card-text max-height="1000px">
              <v-container>
                <v-layout row wrap class="mt-2">
                  <v-flex xs12 md12 sm12 lg12>
                    <v-text-field
                      label="Le titre de la vidéo"
                      prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.titre"
                      dense
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <v-text-field
                        label="L'adresse url de la vidéo"
                        type="url"
                        prepend-inner-icon="link"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        v-model="svData.url"
                        dense
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <v-textarea
                      label="Description de la vidéo"
                      rows="1"
                      prepend-inner-icon="history_edu"
                      outlined
                      v-model="svData.description"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      dense
                    ></v-textarea>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
              <v-btn color="primary" dark :loading="loading" @click="validate">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
      <br /><br />
      <v-layout>
        <v-layout>
          <v-flex md1></v-flex>
          <v-flex md10></v-flex>
          <v-flex md1></v-flex>
        </v-layout>

        <v-flex md12>
          <!-- bande -->
          <v-layout>
            <v-flex md1>
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn :loading="loading" fab @click="onPageChange">
                      <v-icon>autorenew</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Initialiser</span>
              </v-tooltip>
            </v-flex>
            &nbsp;&nbsp;
            <v-flex md4>
              <v-text-field
                append-icon="search"
                label="Recherche..."
                single-line
                solo
                outlined
                rounded
                hide-details
                v-model="query"
                @keyup="searchMember"
                clearable
              ></v-text-field>
            </v-flex>

            <v-flex md6></v-flex>

            <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="showModal" fab color="primary">
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter une opération</span>
              </v-tooltip>
            </v-flex>
          </v-layout> 
          <!-- bande -->

          <br />

         
          <!-- les composants -->

          <v-card
            :loading="loading"
            class="mx-auto my-0"

        >
           

            <v-card-text>
           
                <div class="block galleryBlock">
                    <v-container>
                    
                        <v-row>

                            <v-col v-for="item in fetchData" :key="item.id" class="d-flex child-flex" cols="6" sm="12">
                                <v-card flat tile class="d-flex">


                                    <div class="mr-2" 
                                    style="cursor: pointer;">
                                    
                                       
                                        
                                        <v-layout row wrap>
                                            <v-flex xs12 md12 lg12 sm12>

                                                <v-row justify="center">
                                                    <v-expansion-panels inset>
                                                        <v-expansion-panel
            
                                                        >
                                                            <v-expansion-panel-header width="100%"> 
                                                                {{item.titre}}
                                                                <v-spacer></v-spacer> 
                                                                <v-icon class="mr-1">pending_actions</v-icon>
                                                                {{ item.created_at | formatDate }}
                                                                {{ item.created_at | formatHour }}
                                                            </v-expansion-panel-header>
                                                            <v-expansion-panel-content>

                                                                <v-card flat>
                                                                    <v-card-text>
                                                                        <video-embed
                                                                         width="100%"
                                                                         css="embed-responsive-21by9"  
                                                                         :src="item.url">
                                                                        </video-embed>

                                                                        <v-layout row wrap>
                                                                            <v-flex xs12 sm12 md11 lg11>
                                                                                {{item.description}}
                                                                            </v-flex>
                                                                            <v-flex xs12 sm12 md1 lg1>
                                                                                <v-spacer></v-spacer> 
                                                                                <v-menu
                                                                                    bottom
                                                                                    rounded
                                                                                    offset-y
                                                                                    transition="scale-transition"
                                                                                >
                                                                                    <template v-slot:activator="{ on }">
                                                                                    <v-btn icon v-on="on" small fab depressed text>
                                                                                        <v-icon>more_vert</v-icon>
                                                                                    </v-btn>
                                                                                    </template>

                                                                                    <v-list dense width="">
                                                                                        


                                                                                        <v-list-item
                                                                                            
                                                                                            link
                                                                                            @click="editData(item.id)"
                                                                                            
                                                                                        >
                                                                                            <v-list-item-icon>
                                                                                                <v-icon>edit</v-icon>
                                                                                            </v-list-item-icon>
                                                                                            <v-list-item-title style="margin-left: -20px"
                                                                                            >Modifier la vidéo</v-list-item-title
                                                                                            >
                                                                                        </v-list-item>

                                                                                        <v-list-item
                                                                                            
                                                                                            link
                                                                                            @click="clearP(item.id)"
                                                                                            
                                                                                        >
                                                                                            <v-list-item-icon>
                                                                                                <v-icon>delete</v-icon>
                                                                                            </v-list-item-icon>
                                                                                            <v-list-item-title style="margin-left: -20px"
                                                                                            >Supprimer la vidéo</v-list-item-title
                                                                                            >
                                                                                        </v-list-item>

                                                                                    
                                                                                    </v-list>
                                                                                </v-menu>
                                                                            </v-flex>
                                                                        </v-layout>

                                                                         

                                                                        
                                                                    </v-card-text>
                                                                    
                                                                </v-card>

                                                           
                                                            </v-expansion-panel-content>
                                                           
                                                        </v-expansion-panel>
                                                    </v-expansion-panels>
                                                </v-row>


                                                
                                            </v-flex>
                                        </v-layout>
                                       <br>
                                    </div> 

                                    
                                   
                                    
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

          <!-- fin des composants -->
        </v-flex>
      </v-layout>
    </v-flex>


       
        
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    components:{
    },
    data(){
        return{
            titleComponent:"Liste video",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            selection: 0,

            fetchData: null,
            query:"",

            style: {
                height: "0px",
            },
            svData: {
                id: "",
                ceo: "",
                titre: "",
                description: "",
                url: "",
            },
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
            this.fetch_data(`${this.apiBaseURL}/fetch_video_entreprise/${slug}?page=`);
        },

        showModal() {
            this.dialog = true;
            this.titleComponent = "Paramètrage vidéo ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de vidéo";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage vidéo ";
                this.style.height = "0px";
            }
        },

        validate() {
            if (this.edit == false) {
              this.svData.ceo = this.projectDetail.id;
            }
            if (this.$refs.form.validate()) {

                
                this.isLoading(true);

                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_video_entreprise`,
                JSON.stringify(this.svData)
                )
                .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.resetObj(this.svData);
                    this.onPageChange();

                    this.$emit("initialisateur");

                    this.dialog = false;


                })
                .catch((err) => {
                    this.svErr(), this.isLoading(false);
                });
            }
        },

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_video_entreprise/${id}`).then(
                ({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.svData.id = item.id;
                    this.titleComponent = "modification de la vidéo ";
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_video_entreprise/${id}`).then(
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

