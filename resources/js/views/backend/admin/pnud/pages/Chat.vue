<template>
    <v-container fluid>
        <ListeChat v-bind:drawer="drawer" v-bind:user="userData" />
        <v-row>
            <v-col cols="12" sm="3" class="border">

                <v-app-bar flat color="rgba(0,0,0,0)">
                    <v-btn tile x-large block @click.stop="showChatGroupConversation()">
                        <v-icon left color="blue">
                            outgoing_mail
                        </v-icon>
                        <v-divider class="mx-3" vertical></v-divider>
                        groupe
                    </v-btn>
                </v-app-bar>

                <v-app-bar flat color="rgba(0,0,0,0)">
                    <v-toolbar-title class="title">
                        Chat
                    </v-toolbar-title>

                    <v-spacer></v-spacer>
                    <v-btn icon>
                        <v-icon>mark_email_read</v-icon>
                    </v-btn>
                </v-app-bar>
                <v-app-bar flat color="rgba(0,0,0,0)">

                    <v-text-field filled label="Search Here" append-icon="mdi-magnify" color="grey" v-model="query"
                        @keyup="searchMember2"></v-text-field>
                </v-app-bar>

                <v-list two-line color="rgba(0,0,0,0)">
                    <v-list-item-group v-model="selected" active-class="blue lighten-4">
                        <template>
                            <v-list-item v-for="friend in fetchData" :key="friend.id" @click="activeFriend = friend.id">
                                <v-badge bordered bottom dot offset-x="22" offset-y="26"
                                    :color="(onlineFriends.find(user => user.id === friend.id)) ? 'green' : 'red'">
                                    <v-list-item-avatar>
                                        <userImage :width="40" :height="40" :image="friend.avatar" />

                                    </v-list-item-avatar>
                                </v-badge>
                                <template>
                                    <v-list-item-content>
                                        <v-list-item-title v-text="friend.name"></v-list-item-title>

                                        <v-list-item-subtitle v-text="friend.email"></v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                            </v-list-item>

                            <v-divider></v-divider>

                            <v-flex xs12 md12 lg12 sm12>

                                <div class="text-center">
                                    <v-pagination color="primary" v-model="pagination.current"
                                        :length="pagination.total" :total-visible="0" @input="onPageChangeUser">
                                    </v-pagination>
                                </div>

                            </v-flex>


                        </template>
                    </v-list-item-group>
                </v-list>

            </v-col>
            <v-col cols="12" sm="6" class="border">
                <!-- message here -->



                <v-flex id="privateMessageBox" class="messages mb-5" xs12 md12 lg12 sm12>
                    <v-list>
                        <v-list-item class="p-3" v-for="(message, index) in allMessages" :key="index">

                            <v-layout :align-end="(user.id !== message.user.id)" column>
                                <v-flex md12 lg12 sm12>
                                    <v-layout column>
                                        <v-flex md12>
                                            <span class="small font-italic">{{ message.user.name }}</span>
                                        </v-flex>

                                        <v-flex md12>

                                            <div
                                                :class="(user.id !== message.user.id) ? 'red darken-1 rounded-tl-0' : 'green darken-1 rounded-tl-0'">

                                                <v-list-item-content clss="rounded-tl-0" @dblclick="visibilitymenu = !visibilitymenu">
                                                    <v-container grid-list-xs>
                                                        {{ message.message }}

                                                       
                                                    </v-container>
                                                </v-list-item-content>

                                            </div>


                                        </v-flex>

                                        <v-flex class="caption font-italic">

                                            {{
                                                    moment(message.created_at).
                                                    format('DD-MM-YYYY,h:mm: ss a') 
                                            }}

                                            <v-spacer></v-spacer>
                                            <span class="ml-16"
                                                v-if="user.id === message.user_id" v-show="visibilitymenu ? true : false">


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
                                            
                                        </v-flex>
                                        <div class="image-container" style="max-width: 300px; max-height: 200px;">
                                            <img v-if="message.image" :src="`${baseURL}/storage/${message.image}`" alt="">

                                        </div>
                                    </v-layout>
                                </v-flex>
                            </v-layout>


                        </v-list-item>

                        

                        <v-list-item class="p-3" v-if="allMessages.length <= 0" >

                            <v-layout wrap row>
                                <v-flex md2 lg2 sm2></v-flex>

                                <v-flex md8 lg8 sm8 class="mt-4">
                                   <v-avatar
                                    size="100%"
                                    color="lime lighten-5"
                                    tile
                                   >
                                    <img 
                                    :src="
                                        `${baseURL}/images/chat2.jpg`
                                    "
                                     alt="alt">
                                   </v-avatar>
                                </v-flex>

                                <v-flex md2 lg2 sm2></v-flex>


                            </v-layout>


                        </v-list-item>


                    </v-list>

                    <div class="floating-div">
                        <picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji…" />

                    </div>


                   



                </v-flex>

                <!-- fin message -->

                <!-- content form -->
                <v-flex xs12 sm6 md12 lg12 class="mt-4">
                    <v-layout row wrap class="mt-2">
                         

                         <v-flex class="ml-2 text-center" xs12>
                           <p v-if="typingFriend.name">{{ typingFriend.name }} entré d'écrire...</p>
                                
                        </v-flex>
                        <v-flex class="ml-2 text-right" xs1>
                            <v-btn @click="toggleEmo" fab dark small color="pink">
                                <v-icon>insert_emoticon </v-icon>
                            </v-btn>
                        </v-flex>

                        <!-- <v-flex xs1 class="text-center">
                            <file-upload :post-action="`/private-messages/${activeFriend}`" ref='upload'
                                @input-file="$refs.upload.active = true"
                                :headers="{ 'X-CSRF-TOKEN': token }">
                                <v-icon class="mt-3">attach_file</v-icon>
                            </file-upload>

                        </v-flex> -->
                        <v-flex xs10>
                           
                            <v-app-bar color="rgba(0,0,0,0)" flat>
                                
                                <v-textarea label="Message" rows="1" append-icon="outgoing_mail"
                                    :append-outer-icon="'mdi-send'" filled clear-icon="mdi-close-circle"
                                    clearable v-model="message" 
                                    @click:append-outer="sendMessage" 
                                    dense
                                    @keydown="onTyping"
                                    >
                                </v-textarea>
                            </v-app-bar>


                        </v-flex>
                        <v-flex xs1>

                        </v-flex>



                    </v-layout>
                </v-flex>
                <!-- fin content form -->

            </v-col>
            <v-col cols="12" sm="3">
                <listeChatSliderLeft />

            </v-col>
        </v-row>
    </v-container>

</template>

<script>
import { Picker } from 'emoji-mart-vue'
import ListeChat from './listeChat.vue'
import Menuleft from './menufelt.vue';
import listeChatSliderLeft from './listeChatSliderLeft.vue'
import userImage from '../../../../component/userImage.vue';
export default {
    components: {
        ListeChat,
        Menuleft,
        listeChatSliderLeft,
        userImage,
        Picker,

    },

    props: ['user'],

    data: () => ({
        drawer: null,
        selected: [],
        visibilitymenu: false,



        panel: [2],

        password: 'Password',
        show: false,
        marker: true,
        iconIndex: 0,
        infoListChat: [],

        query: "",
        fetchData: null,

        //debut
        message: null,
        activeFriend: null,
        typingFriend: {},
        onlineFriends: [],
        allMessages: [],
        typingClock: null,
        users: [],
        //fin

        emoStatus: false,
        myText: null,
        token: document.head.querySelector('meta[name="csrf-token"]').content,

    }),
    computed: {
        friends() {
            return this.users.filter((user) => {
                return user.id !== this.user.id;
            })
        }
    },
    watch: {
        activeFriend(val) {
            this.fetchMessages();
        }
    },
    mounted() {
    },
    created() {

        // this.fetchUsers();
        this.onPageChangeUser();

        Echo.join('plchat')
            .here((users) => {
                console.log('online', users);
                this.onlineFriends = users;
            })
            .joining((user) => {
                this.onlineFriends.push(user);
                console.log('joining', user.name);
            })
            .leaving((user) => {
                this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
                console.log('leaving', user.name);
            });

        Echo.private('privatechat.' + this.user.id)
            .listen('PrivateMessageSent', (e) => {
                console.log('pmessage sent')
                this.activeFriend = e.message.user_id;
                this.allMessages.push(e.message)
                setTimeout(this.scrollToEnd, 100);
            })
            .listenForWhisper('typing', (e) => {
                if (e.user.id == this.activeFriend) {
                    this.typingFriend = e.user;

                    if (this.typingClock) clearTimeout();
                    this.typingClock = setTimeout(() => {
                        this.typingFriend = {};
                    }, 9000);
                }

            });

    },
    methods: {

        showChatGroupConversation() {
            this.drawer = !this.drawer;
        },
        onTyping() {
            Echo.private('privatechat.' + this.activeFriend).whisper('typing', {
                user: this.user
            });
        },
        sendMessage() {
            //check if there message
            if (!this.message) {
                
                return this.showError("Veillez saisire le message svp!");
            }
            if (!this.activeFriend) {
               
                return this.showError("Veillez selectionner un ami pour envoyer le message svp!");
            }
            axios.post('/private-messages/' + this.activeFriend, { message: this.message }).then(response => {
                this.message = null;
                this.allMessages.push(response.data.message)
                setTimeout(this.scrollToEnd, 100);
            });
        },
        fetchMessages() {
            if (!this.activeFriend) {
                // return alert('Please select friend');
                return this.showError("Veillez selectionner un ami pour faire la conversation svp!");
            }
            axios.get('/private-messages/' + this.activeFriend).then(response => {
                this.allMessages = response.data;
            });
        },
        fetchUsers() {
            var url = `${this.apiBaseURL}/get_all_users`
            axios.get(url).then(response => {
                this.users = response.data.data;
                if (this.friends.length > 0) {
                    this.activeFriend = this.friends[0].id;
                }
            });




        },
        scrollToEnd() {
            document.getElementById('privateMessageBox').scrollTo(0, 99999);
        },


        //fetch ceo
        searchMember2: _.debounce(function () {
            this.onPageChangeUser();
        }, 300),
        onPageChangeUser() {
            this.fetchUsers();
            this.fetch_data(`${this.apiBaseURL}/get_all_users?page=`);
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

         clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/destroyMessage/${id}`).then(
                    ({ data }) => {
                        // this.successMsg(data.data);
                        this.showMsg(data.data);
                        this.fetchMessages();
                    }
                );
            });
        },





    },

};
</script>
<style scoped>
.border {
    border-right: 1px solid grey;
}

.online-users,
.messages {
    overflow-y: scroll;
    height: 70vh;
}
</style>