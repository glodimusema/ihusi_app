<template>
    <div>
        <v-card
            :loading="loading"
            class="mx-auto my-1"
            max-width="374"
        >
            <template slot="progress">
            <v-progress-linear
                color="deep-purple"
                height="10"
                indeterminate
            ></v-progress-linear>
            </template>

            <img
                height="auto"
                width="100%"
                :src="
                projectDetail.logo == null
                    ? `${baseURL}/images/logo.png`
                    : `${baseURL}/images/` + projectDetail.logo
                "
            />

            <v-card-title>{{projectDetail.nomEntreprise}}</v-card-title>

            <v-card-text>
            <v-row
                align="center"
                class="mx-0"
            >
                <v-rating
                :value="4.5"
                color="amber"
                dense
                half-increments
                readonly
                size="14"
                ></v-rating>

                <div class="grey--text ms-4">
                    {{ projectDetail.created_at | formatDate }}
                    {{ projectDetail.created_at | formatHour }}
                </div>
            </v-row>

            <div class="my-4 text-subtitle-1">
                <div><v-icon small class="mr-1">mail</v-icon> Email: <a class="text-subtitle-1 link_pro" :href="'mailto:'+projectDetail.emailEntreprise">{{projectDetail.emailEntreprise}}</a></div>
                <div><v-icon small class="mr-1">call</v-icon> N° de téléphone:<a class="text-subtitle-1 link_pro" :href="'tel:'+projectDetail.telephoneEntreprise">{{projectDetail.telephoneEntreprise}}</a></div>
                <div><v-icon small class="mr-1">push_pin</v-icon> Adresse domicile:{{projectDetail.adresseEntreprise}}</div>
            </div>

            <div>{{projectDetail.descriptionEntreprise}}</div>
            </v-card-text>

            <v-divider class="mx-4"></v-divider>

            <v-card-title>Visibilité sociale</v-card-title>

            <v-card-text>
            <v-chip-group
                v-model="selection"
                active-class="deep-purple accent-4 white--text"
                column
            >
                <v-chip v-show="projectDetail.facebook != null ? true : false" link :href="projectDetail.facebook" target="_blank">Facebook</v-chip>

                <v-chip v-show="projectDetail.twitter != null ? true : false" link :href="projectDetail.twitter" target="_blank">Twitter</v-chip>
                <v-chip v-show="projectDetail.linkedin != null ? true : false" link :href="projectDetail.linkedin" target="_blank">Linkedin</v-chip>
                <v-chip v-show="projectDetail.siteweb != null ? true : false" link :href="projectDetail.siteweb" target="_blank">Site web</v-chip>
            </v-chip-group>
            </v-card-text>

            <v-card-actions>
            <v-btn
                color="deep-purple lighten-2"
                text
                @click="reserve"
            >
                Reserve
            </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data(){
        return{
            title:"Detail de l'entreprise",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            selection: 0,
        }

    },
    created(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);

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

        

    },

}
</script>
<style scoped>
.link_pro{
    text-decoration: none;
}
</style>

