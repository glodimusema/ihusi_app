<template>
    <div>
        <!-- composent -->
        <v-layout
            row
            wrap
            class="mt-0"
            >
            <!-- statistique -->
            <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->

                    <v-list-item three-line router to="/admin/compte"> 
                    <v-list-item-content>
                        <div class="text-overline mb-4">Nombre total des administrateurs</div>
                        <v-list-item-title class="text-h5 mb-1">
                            {{svData.NombreAdmin}}
                        </v-list-item-title>
                        <v-list-item-subtitle>dans le système</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="grey">
                        <v-icon size="60" color="white">admin_panel_settings</v-icon>
                    </v-list-item-avatar>

                    </v-list-item>
                    <!-- fin card -->
                </v-card>
                </v-container>
            </v-flex>

            <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->
                    <v-list-item three-line router to="/admin/liste_entreprise">
                    <v-list-item-content>
                        <div class="text-overline mb-4">Nombre total des legas </div>
                        <v-list-item-title class="text-h5 mb-1">
                         {{svData.NombreTotalPersonne}} 
                        </v-list-item-title>
                        <v-list-item-subtitle
                        >Dans le système</v-list-item-subtitle
                        >
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="grey">
                        <v-icon size="60" color="white">manage_accounts</v-icon>
                    </v-list-item-avatar>
                    </v-list-item>

                    <!-- fin card -->
                   
                </v-card>
                </v-container>
            </v-flex>

            <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->
                    <v-list-item three-line router to="/admin/compte">
                    <v-list-item-content>
                        <div class="text-overline mb-4">Nombre total des Membres</div>
                        <v-list-item-title class="text-h5 mb-1">
                         {{svData.NombreMembre}}  
                        </v-list-item-title>
                        <v-list-item-subtitle
                        >Dans le système </v-list-item-subtitle
                        >
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="grey">
                        <v-icon size="60" color="white">group_add</v-icon>
                    </v-list-item-avatar>
                    </v-list-item>

                   

                    <!-- fin card -->
                </v-card>
                </v-container>
            </v-flex>

             <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->
                    <v-list-item three-line router to="/admin/compte">
                    <v-list-item-content>
                        <div class="text-overline mb-4">Nombre total des utilisateur</div>
                        <v-list-item-title class="text-h5 mb-1">
                        {{svData.NombreTotalUtilisateur}}
                        </v-list-item-title>
                        <v-list-item-subtitle
                        >Dans le système</v-list-item-subtitle
                        >
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="grey">
                        <v-icon size="60" color="white">supervised_user_circle</v-icon>
                    </v-list-item-avatar>
                    </v-list-item>

                   

                    <!-- fin card -->
                </v-card>
                </v-container>
            </v-flex>

            <!-- fin statistique -->
            </v-layout>

           

            <v-layout row wrap>
                <v-flex md6 xs12 sm12  lg6 class="mb-1">
                    <v-container>
                    <dashRoleUsers v-bind:typechart="stat.typechart2" />
                    </v-container>
                </v-flex>

                <v-flex md6 xs12 sm12  lg6 class="mb-1">
                    <v-container>
                    <dashRoleUsers v-bind:typechart="stat.typechart3" />
                    </v-container>
                </v-flex>
           
            </v-layout>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import dashRoleUsers from "./dashRoleUsers.vue";
export default {
    components:{
        dashRoleUsers,

    },
    data(){
        return{
            titre: "Mon tableau de bord",
            team: [],
            query: "",
            dialog: false,
            loading: false,
            disabled: false,

           

            fav: false,
            stat: {
                options: null,
                series: null,
                typechart1: "line",
                typechart2: "area",
                typechart3: "bar",
                typechart4: "donut",
            },

            svData: {
                NombreTotalUtilisateur: '',
                NombreTotalPersonne:'',
                NombreMembre:'',
                NombreAdmin:'',

                NombreAgentActif:'',
                NombreAgentInactif:'',
                
            },

            sheet: false,

            picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            
            query: "",
            fetchData: null,
            

        }

    },
    created() {
        this.showCountNotification();

    },
    computed: {
        ...mapGetters(["roleList","isloading"]),
    },
    methods: {
         ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList"
        ]),
        

        showCountNotification() {
            var id_user = this.userData.id;
            this.editOrFetch(
                `${this.apiBaseURL}/showCountDashbord`
            ).then(({ data }) => {
                var donnees = data.data;

                this.getSvData(this.svData, data.data[0]);

            });
        },

        
    },

}
</script>
<style scoped>
#views {
  max-height: 470px;
  overflow: scroll;
}
#views2 {
  max-height: 250px;
  overflow: scroll;
}


</style>
