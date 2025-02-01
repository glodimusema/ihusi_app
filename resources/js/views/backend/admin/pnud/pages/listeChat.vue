<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12 md12 lg12 sm12>
                <v-navigation-drawer v-model="drawer" absolute right temporary width="520">

                    <v-container grid-list-xs>

                        <!-- list chat -->
                        <v-layout row class="mt-3">
                            <v-flex xs12 sm6 md12 lg12>
                                <v-card class="chat-card">

                                    <v-list>
                                        <v-subheader>
                                            Group Chat
                                        </v-subheader>
                                        <v-divider></v-divider>
                                        <div class="messages">

                                            <v-list class="p-3 mb-2 mt-8" v-for="(message, index) in allMessages"
                                                :key="index">
                                                <div class="message-wrapper">
                                                    <v-container grid-list-xs>

                                                        <v-app-bar color="rgba(0,0,0,0)" flat class="mb-16">

                                                            <v-spacer v-if="user.id === message.user_id"></v-spacer>
                                                            <v-badge bordered bottom color="green" dot offset-x="16"
                                                                offset-y="9" v-if="user.id !== message.user_id">
                                                                <v-avatar class="mt-n5 mr-2" size="30" elevation="10">
                                                                    <img :src="
                                                                        message.user.avatar == null
                                                                            ? `${baseURL}/images/avatar.png`
                                                                            : `${baseURL}/images/` + message.user.avatar
                                                                    " />
                                                                </v-avatar>


                                                            </v-badge>
                                                            <v-card class="mt-10 mr-2" max-width="350px"
                                                                :color="(user.id === message.user_id) ? 'green' : 'red'"
                                                                dark rounded flat>
                                                                <v-list-item three-line>
                                                                    <v-list-item-content @dblclick="visibilitymenu = !visibilitymenu">
                                                                        <div class=" mb-4">
                                                                            {{ message.message }}
                                                                        </div>
                                                                        <div class="image-container">

                                                                            <img v-if="message.image"
                                                                                :src="`${baseURL}/storage/${message.image}`"
                                                                                alt="">

                                                                        </div>
                                                                        <v-list-item-subtitle>
                                                                            {{
                                                                                 moment(message.created_at).
                                                                                 format('DD-MM-YYYY,h:mm: ss a') 
                                                                            }}
                                                                            <span class="ml-16"
                                                                                v-if="user.id === message.user_id"
                                                                                v-show="visibilitymenu ? true : false" 
                                                                            >


                                                                                <!-- menu -->
                                                                                <v-menu bottom rounded offset-y
                                                                                    transition="scale-transition">
                                                                                    <template v-slot:activator="{ on }">
                                                                                        <v-btn icon v-on="on" small fab
                                                                                            depressed text>
                                                                                            <v-icon>more_vert</v-icon>
                                                                                        </v-btn>
                                                                                    </template>

                                                                                    <v-list dense width="">


                                                                                        <v-list-item link
                                                                                            @click="clearP(message.id)">
                                                                                            <v-list-item-icon>
                                                                                                <v-icon color="red">
                                                                                                    delete
                                                                                                </v-icon>
                                                                                            </v-list-item-icon>
                                                                                            <v-list-item-title
                                                                                                style="margin-left: -20px">
                                                                                                Supprimer
                                                                                            </v-list-item-title>
                                                                                        </v-list-item>


                                                                                    </v-list>
                                                                                </v-menu>
                                                                                <!-- fin menu -->

                                                                            </span>

                                                                        </v-list-item-subtitle>
                                                                    </v-list-item-content>
                                                                </v-list-item>
                                                                <v-spacer></v-spacer>
                                                                <span class="small font-italic">{{ message.user.name
                                                                }}</span>
                                                            </v-card>

                                                            <v-badge bordered bottom color="light" dot offset-x="10"
                                                                offset-y="10" v-if="user.id === message.user_id">

                                                                <v-avatar class="mt-n5 " size="30" elevation="10">

                                                                    <img :src="
                                                                        message.user.avatar == null
                                                                            ? `${baseURL}/images/avatar.png`
                                                                            : `${baseURL}/images/` + message.user.avatar
                                                                    " />

                                                                </v-avatar>


                                                            </v-badge>
                                                        </v-app-bar>


                                                    </v-container>


                                                </div>

                                            </v-list>

                                        </div>


                                    </v-list>
                                </v-card>

                            </v-flex>

                            <div class="floating-div">
                                <picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji…" />

                            </div>
                            <v-flex xs12 sm6 md12 lg12 class="mt-4">
                                <v-layout row wrap class="mt-2">
                                    <v-flex class="ml-2 text-right" xs1>
                                        <v-btn @click="toggleEmo" fab dark small color="pink">
                                            <v-icon>insert_emoticon </v-icon>
                                        </v-btn>
                                    </v-flex>

                                    <v-flex xs1 class="text-center">
                                        <file-upload post-action="/messages" ref='upload'
                                            @input-file="$refs.upload.active = true"
                                            :headers="{ 'X-CSRF-TOKEN': token }">
                                            <v-icon class="mt-3">attach_file</v-icon>
                                        </file-upload>

                                    </v-flex>
                                    <v-flex xs9>

                                        <v-app-bar color="rgba(0,0,0,0)" flat>

                                            <v-textarea label="Message" rows="1" append-icon="outgoing_mail"
                                                :append-outer-icon="'mdi-send'" filled clear-icon="mdi-close-circle"
                                                clearable v-model="message" @click:append-outer="sendMessage" dense>
                                            </v-textarea>
                                        </v-app-bar>




                                    </v-flex>
                                    <v-flex xs1>

                                    </v-flex>



                                </v-layout>
                            </v-flex>




                        </v-layout>
                        <!-- fin liste chat -->

                    </v-container>




                </v-navigation-drawer>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import { Picker } from 'emoji-mart-vue'
import userImage from '../../../../component/userImage.vue';
export default {
    props: ['user', 'drawer'],
    components: {
        Picker,
        userImage,
    },

    

    data() {
        return {
            visibilitymenu: false,
            message: null,
            emoStatus: false,
            myText: null,
            allMessages: [],
            token: document.head.querySelector('meta[name="csrf-token"]').content,
           
        }
    },
    
    methods: {
        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/destroyMessage/${id}`).then(
                    ({ data }) => {
                        // this.successMsg(data.data);
                        this.showMsg(data.data);
                        this.chargement();
                    }
                );
            });
        },
        sendMessage() {
            //check if there message
            if (!this.message) {
                // return alert('Please enter message');
                this.showError("Veillez saisire le message svp!");
            }
            axios.post('/messages', { message: this.message }).then(response => {
                this.message = null;
                this.emoStatus = false;
                this.allMessages.push(response.data.message)
                setTimeout(this.scrollToEnd, 100);
            });
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.allMessages = response.data;
            });
        },
        scrollToEnd() {
            window.scrollTo(0, 99999);
        },
        onInput(e) {
            if (!e) {
                return false;
            }
            if (!this.message) {
                this.message = e.native;
            } else {
                this.message = this.message + e.native;
            }
        },
        toggleEmo() {
            this.emoStatus = !this.emoStatus;
        },

        chargement() {
            this.fetchMessages();
            Echo.private('lchat')
                .listen('MessageSent', (e) => {
                    this.allMessages.push(e.message)
                    setTimeout(this.scrollToEnd, 100);
                });
        }
    },
    mounted() {
        this.drawer = null;
    },
    created() {
        this.fetchMessages();
        Echo.private('lchat')
            .listen('MessageSent', (e) => {
                this.allMessages.push(e.message)
                setTimeout(this.scrollToEnd, 100);
            });
    },
    filters: {
        moment: function (date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        }
    }

}
</script>

<style scoped>
.chat-card {
    margin-bottom: 10px;

}

.floating-div {
    position: fixed;
}

.chat-card img {
    max-width: 300px;
    max-height: 200px;

}

.messages {
    overflow-y: scroll;
    height: 60vh;
}
</style>

