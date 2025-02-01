<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="500">
      <v-card>
        <v-form ref="form" lazy-validation>
          <v-card-title class="text-h6 primary">
            Importation les images des vos activités <v-spacer></v-spacer>
            <v-btn fab small depressed text @click="dialog = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            
            <br />

            <input
              type="file"
              id="photo_input"
              @change="onImageChange"
              required
            />
            <img style="height: 100px" id="output" />
            
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
            .post(`${this.apiBaseURL}/add_photo_entreprise`, formData, config)
            .then(({ data }) => {
                this.image = "";
                this.showMsg(data.data);

                this.$emit("initialisateur");

                // setTimeout(() => window.location.reload(), 2000);
                document.getElementById("photo_input").value = "";
                document.getElementById("output").src = "";
                
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