<template>
    <div>
        <v-btn depressed text @click="exportToExcel"> Exporter vers Excel </v-btn>
    </div>
  </template>
  
  <script>
  import { mapGetters, mapActions } from "vuex";
  import axios from 'axios';
  import * as XLSX from 'xlsx';
  
  export default {
    
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
        async exportToExcel() {
            try {
                const response = await axios.get(`${this.apiBaseURL}/fetch_categorie_produit_2`);
                let users = response.data; // Changez const en let

                console.log('Réponse de API:', users); // Vérifiez la structure des données

                // Adapter l'accès aux données en fonction de la structure
                if (Array.isArray(users)) {
                    // C'est déjà un tableau
                } else if (users.data && Array.isArray(users.data)) {
                    users = users.data; // Accéder au tableau
                } else if (users.products && Array.isArray(users.products)) {
                    users = users.products; // Accéder au tableau
                } else {
                    throw new Error('Les données récupérées ne sont pas un tableau');
                }

                const worksheet = XLSX.utils.json_to_sheet(users);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                XLSX.writeFile(workbook, 'users.xlsx');
            } catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        }
    }
  }
  </script>