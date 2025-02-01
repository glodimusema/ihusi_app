<template>
    <div>
        <!-- <ChatComponent v-bind:user="userData" /> -->
        <Chat v-bind:user="userData" />
        <!-- <TempleteChat /> -->
    </div>
</template>
<script>
import TempleteChat from './templeteChat.vue'
import ChatComponent from './chatComponent.vue'
import Chat from './Chat.vue'
export default {
    components:{
        ChatComponent,
        Chat,
        TempleteChat,
    },
    data(){
        return{
            title: "groupe chat",
        }
    },
    methods:{

    },
    
}
</script>

