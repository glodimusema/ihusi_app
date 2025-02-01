<template>
  <v-card class="mx-auto" max-width="400">
    <div class="text-center">
      <v-avatar size="100">
        <img
          class="white--text align-end"
          height="200px"
          :src="
            svData.avatar == null
              ? `${baseURL}/images/avatar.png`
              : `${baseURL}/images/` + svData.avatar
          "
        />
      </v-avatar>
    </div>
    <v-card-title>{{ svData.name }}</v-card-title>

    <v-card-subtitle class="pb-0"> {{ svData.email }} </v-card-subtitle>

    <v-card-text class="text--primary">
      <div>De son vrai nom {{ svData.name }}</div>
      <div>N° de téléphone {{ svData.telephone }}</div>
      <div>Adresse domicile {{ svData.adresse }}</div>

      <div>Sexe: {{ svData.sexe }}</div>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      title: "Basic",
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        name: "",
        email: "",
        password: "",
        // photo: "",
        sexe: "",
        avatar: "",
        telephone: "",
        adresse: "",
      },
      fetchData: null,
      titreModal: "",
    };
  },

  computed: {
    ...mapGetters(["userList", "isloading"]),
  },
  created() {
    this.editData(this.userData.id);
  },
  methods: {
    ...mapActions(["getUser"]),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/showUser/${id}`).then(({ data }) => {
        var donnees = data.data;

        //   donnees.map((item) => {
        //     this.svData.name = item.name;
        //     this.svData.email = item.email;
        //     this.svData.sexe = item.sexe;
        //     this.svData.id_role = item.name;
        //     this.svData.id = item.user_id;
        //     this.titleComponent = "modification de " + item.name;
        //   });

        this.getSvData(this.svData, data.data[0]);
        this.edit = true;
        this.dialog = true;
      });
    },
  },
};
</script>