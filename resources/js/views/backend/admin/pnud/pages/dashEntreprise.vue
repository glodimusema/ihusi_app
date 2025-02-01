<template>
    <div>
        

        <v-card class="pa-2" :loading="loading" :disabled="isloading" outlined tile elevation="2">
            <v-card-text>
                <!-- insertion stat 2 -->
                <div class="chart-wrapper">
                    <div class="text-center text-h7">
                        {{titre}}
                        <v-divider></v-divider>
                    </div>
                    <column-chart :data="list"></column-chart>
                </div>
                <!-- insertion stat 2 -->
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    props:['list','titre'],
    data(){
        return{
            title: "titre chart 1",
            loading: false,
            

        }
    },
    computed: {
        ...mapGetters(["isloading"]),
    },
    methods:{

        ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList"
        ]),

       

    },
    created(){
       
    },
}
</script>

