<template>
    <div>

        <v-card class="text-center mt-8 mb-3" shaped>
            <v-badge bordered bottom color="green" dot offset-x="11" offset-y="13">
                <v-avatar class="mt-n7" size="60" elevation="10">
                    <img 
                    :src="
                        svData.avatar == null
                        ? `${baseURL}/images/avatar.png`
                        : `${baseURL}/images/` + svData.avatar
                    "
                        />
                </v-avatar>
            </v-badge>
            <v-card-title class="layout justify-center">{{svData.name}}</v-card-title>
            <v-card-subtitle class="layout justify-center">
                <div>Sexe: {{svData.sexe}}</div> 
                <div>Email: {{svData.email}}</div> <br />
                
            </v-card-subtitle>
            
            
            <v-list>
            </v-list>
        </v-card>
        <v-expansion-panels v-model="panel" multiple>
            <v-expansion-panel>
                <v-expansion-panel-header>
                    <h3>Information</h3>
                </v-expansion-panel-header>
                <v-expansion-panel-content>

                    <v-list shaped>
                        <v-list-item-group>
                            <v-list-item>
                                
                                <v-list-item-content>
                                    N° de téléphone:
                                    <v-list-item-title> <a class="text-primary" :href="'tel:'+svData.telephone">{{svData.telephone}}</a></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                
                                <v-list-item-content>
                                    Adresse domicile:
                                    <v-list-item-title> {{svData.adresse}}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>

                </v-expansion-panel-content>
            </v-expansion-panel>
            
            <v-expansion-panel>
                <v-expansion-panel-header v-for="(item, index) in infoListChat" :key="index">
                    <h3>Messages ({{item.NombreSms}})</h3>
                </v-expansion-panel-header>
                <v-expansion-panel-content>

                </v-expansion-panel-content>
            </v-expansion-panel>
            <v-expansion-panel>
                <v-expansion-panel-header  v-for="(item, index) in infoListChat" :key="index">
                    <h3>Fichiers ({{item.NombreSmsImages}}) </h3>
                </v-expansion-panel-header>
                <v-expansion-panel-content v-for="data in infoListChat" :key="data.code">

                        <v-row>

                    <v-col v-for="item in data.messages" :key="item.id" class="d-flex child-flex" cols="6" sm="4">
                        <v-card flat tile class="d-flex">
                            

                            <v-avatar
                                tile 
                                size="60"
                                color="blue lighten-5"
                                @dblclick="clearP(item.id)"
                                v-if="item.image"
                            >
                                <img 
                                    :src="
                                        `${baseURL}/storage/` + item.image
                                    " 
                                    alt="alt">
                            </v-avatar>
                            
                            
                            
                        </v-card>
                    </v-col> 
                        
                </v-row>
                    
                </v-expansion-panel-content>
            </v-expansion-panel>
            


        </v-expansion-panels>

    </div>
</template>
<script>
import ListeChat from './listeChat.vue'
import Menuleft from './menufelt.vue';
export default {
    components: {
        ListeChat,
        Menuleft,

    },

    data: () => ({
        drawer: null,
        selected: [],
        svData: {
            id: "",
            name: "",
            email: "",
            password: "",
            // photo: "",
            sexe: "",
            telephone: "",
            adresse: "",
            avatar: "",
        },
        
        panel: [2],

        password: 'Password',
        show: false,
        message: 'Type a message here',
        marker: true,
        iconIndex: 0,
        infoListChat: [],

    }),
    computed: {
        theme() {
            return this.$vuetify.theme.dark ? "dark" : "light";
        },

    },
    created() {
        this.showUserConnected();
        this.fetchMessagesTug();
    },
    methods: {
        sendMessage() {
            this.resetIcon()
            this.clearMessage()
        },
        showChatGroupConversation() {
            this.drawer = !this.drawer;
        },
        clearMessage() {
            this.message = ''
        },
        resetIcon() {
            this.iconIndex = 0
        },

        showUserConnected() {
            var id = this.userData.id;
            this.editOrFetch(`${this.apiBaseURL}/showUser/${id}`).then(({ data }) => {

                this.getSvData(this.svData, data.data[0]);
            });
        },

        fetchMessagesTug() {
            var id = this.userData.id;
            this.editOrFetch(`${this.apiBaseURL}/fetchMessagesTug/${id}`).then(({ data }) => {
                var donnees = data.data;
               
                this.infoListChat = donnees;

               
            });
        },


    },

};
</script>
<style scoped>
.border {
    border-right: 1px solid grey;
}
</style>

