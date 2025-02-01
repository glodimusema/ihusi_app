<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="500">
      <v-card>
        <v-form ref="form" lazy-validation>
          <v-card-title class="text-h6 primary">
            Importation de tous les documents <v-spacer></v-spacer>
            <v-btn fab small depressed text @click="dialog = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
              <v-alert border="left" colored-border type="info" elevation="2" class="mt-2">
                Ajouter les documents de l'entreprise, Plan d'affaire de votre projet, le plan financier, 
                les cv complet de tous les membres de votre équipe, et un documment explicatif de votre entreprise!
              </v-alert>
             
            <img style="height: 20px" id="output" />
            
            <br />

            <input
              type="file"
              id="photo_input"
              @change="onImageChange"
              required
            />
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn small text @click="dialog = false"> fermer </v-btn>
            <v-btn
              small
              :loading="loading"
              color="primary"
              @click="insertPhoto"
            >
              Enregistrer
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      dialog: false,
      svData: {
        agentId: "",
      },
      image: "",
      loading: false,
    };
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
    methods: {
        insertPhoto() {
        this.updatePhoto();
        
        },
        onImageChange(e) {
        this.image = e.target.files[0];
        let output = document.getElementById("output");
        output.src = URL.createObjectURL(e.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src); // free memory
        };
        },

        updatePhoto() {
        const config = {
            headers: { "content-type": "multipart/form-data" },
        };

        let formData = new FormData();
        formData.append("data", JSON.stringify(this.svData));
        formData.append("image", this.image);


        axios
            .post(`${this.apiBaseURL}/add_busness_plan`, formData, config)
            .then(({ data }) => {
                this.image = "";
                this.showMsg(data.data);

                this.$emit("initialisateur");

                // setTimeout(() => window.location.reload(), 2000);
                document.getElementById("photo_input").value = "";
                document.getElementById("output").src = "";
                this.dialog= false;

            })
            .catch((err) => this.svErr());
        },

        showoneImageTug() {
        var id = this.svData.agentId;
        var img = this.image;
        console.log("id_user:" + id + " image:" + img);
        },

       
    },
};
</script>