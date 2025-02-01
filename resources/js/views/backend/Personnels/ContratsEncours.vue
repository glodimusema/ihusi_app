<template>

    <div>
    
    <AppreciationAgent ref="AppreciationAgent" />
    <ControleConge ref="ControleConge" />
    <DemandeSoinAgent ref="DemandeSoinAgent" />
    <DemandeSortieAgent ref="DemandeSortieAgent" />
    <EnteteConge ref="EnteteConge" />
    <DetailAffectationRubrique ref="DetailAffectationRubrique" />
    <AvanceSurSalaire ref="AvanceSurSalaire" />
    <DemandeConge ref="DemandeConge" />
    
    <v-layout>
    
    <v-flex md12>
      <v-dialog v-model="dialog" max-width="700px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Affectation Agent <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip>
            </v-card-title>
            <v-card-text>
              <v-layout row wrap>
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Type de Contrat" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="contratList"
                      item-text="nom_contrat" item-value="id" dense outlined
                      v-model="svData.refTypeContrat" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Poste" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="postList"
                      item-text="nom_poste" item-value="id" dense outlined
                      v-model="svData.refPoste" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le lieu d'Affectation" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="lieuList"
                      item-text="nom_lieu" item-value="id" dense outlined
                      v-model="svData.refLieuAffectation" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Mutuelle de Santé" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="mutuelleList"
                      item-text="nom_mutuelle" item-value="id" dense outlined
                      v-model="svData.refMutuelle" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                      item-text="name_serv_perso" item-value="id" dense outlined
                      v-model="svData.refServicePerso" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                      item-text="name_categorie_agent" item-value="id" dense outlined
                      v-model="svData.refCategorieAgent" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="number" label="Durée du contrat (Jour)" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dureecontrat">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="Durée en Lettre (Mois)" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dureeLettre">
                    </v-text-field>
                  </div>
                </v-flex>
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date debtut Essaie" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                      v-model="svData.dateDebutEssaie">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date fin Essaie" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateFinEssaie">
                    </v-text-field>
                  </div>
                </v-flex>
    
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Premier jour de Travail dans la semaine" :items="[
                      { designation: 'LUNDI' },
                      { designation: 'MARDI' },
                      { designation: 'MERCREDI' },
                      { designation: 'JEUDI' },
                      { designation: 'VENDREDI' },
                      { designation: 'SAMEDI' },
                      { designation: 'DIMANCHE' }
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.JourTrail1"></v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Dernier jour de Travail dans la semaine" :items="[
                      { designation: 'LUNDI' },
                      { designation: 'MARDI' },
                      { designation: 'MERCREDI' },
                      { designation: 'JEUDI' },
                      { designation: 'VENDREDI' },
                      { designation: 'SAMEDI' },
                      { designation: 'DIMANCHE' }
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.JourTrail2"></v-autocomplete>
                  </div>
                </v-flex>
    
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Heure de debut du travail/Jour" :items="[
                      { designation: '08H00' },
                      { designation: '09H00' },
                      { designation: '10H00' },
                      { designation: '11H00' },
                      { designation: '12H00' },
                      { designation: '13H00' },
                      { designation: '14H00' },
                      { designation: '15H00' },
                      { designation: '16H00' },
                      { designation: '17H00' },
                      { designation: '18H00' },
                      { designation: '19H00' },
                      { designation: '20H00' },
                      { designation: '21H00' },
                      { designation: '22H00' },
                      { designation: '23H00' },
                      { designation: '24H00' },
                      { designation: '01H00' },
                      { designation: '02H00' },
                      { designation: '03H00' },
                      { designation: '04H00' },
                      { designation: '05H00' },
                      { designation: '06H00' },
                      { designation: '07H00' },
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.heureTrail1"></v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Heure de Fin de travail/Jour" :items="[
                      { designation: '08H00' },
                      { designation: '09H00' },
                      { designation: '10H00' },
                      { designation: '11H00' },
                      { designation: '12H00' },
                      { designation: '13H00' },
                      { designation: '14H00' },
                      { designation: '15H00' },
                      { designation: '16H00' },
                      { designation: '17H00' },
                      { designation: '18H00' },
                      { designation: '19H00' },
                      { designation: '20H00' },
                      { designation: '21H00' },
                      { designation: '22H00' },
                      { designation: '23H00' },
                      { designation: '24H00' },
                      { designation: '01H00' },
                      { designation: '02H00' },
                      { designation: '03H00' },
                      { designation: '04H00' },
                      { designation: '05H00' },
                      { designation: '06H00' },
                      { designation: '07H00' },
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.heureTrail2"></v-autocomplete>
                  </div>
                </v-flex>
    
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Heure de Pause/Jour" :items="[
                      { designation: '08H00' },
                      { designation: '09H00' },
                      { designation: '10H00' },
                      { designation: '11H00' },
                      { designation: '12H00' },
                      { designation: '13H00' },
                      { designation: '14H00' },
                      { designation: '15H00' },
                      { designation: '16H00' },
                      { designation: '17H00' },
                      { designation: '18H00' },
                      { designation: '19H00' },
                      { designation: '20H00' },
                      { designation: '21H00' },
                      { designation: '22H00' },
                      { designation: '23H00' },
                      { designation: '24H00' },
                      { designation: '01H00' },
                      { designation: '02H00' },
                      { designation: '03H00' },
                      { designation: '04H00' },
                      { designation: '05H00' },
                      { designation: '06H00' },
                      { designation: '07H00' },
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.TempsPause"></v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Affectation" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                      v-model="svData.dateAffectation">
                    </v-text-field>
                  </div>
                </v-flex>
    
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="number" label="Nombre de jour de Congé Annuel" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nbrConge">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="Nombre de jour de Congé Annuel en Lettre" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nbrCongeLettre">
                    </v-text-field>
                  </div>
                </v-flex>
    
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="nom Office" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nomOffice">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="Post-nom Office" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.postnomOffice">
                    </v-text-field>
                  </div>
                </v-flex>
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="Qualification Office" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qualifieOffice">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-autocomplete label="Selectionnez le Directeur" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                    item-value="noms_agent" dense outlined v-model="svData.directeur" chips clearable>
                  </v-autocomplete>
                </div>
              </v-flex>  
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="N° AGENT " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.codeAgent">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="N° CNSS" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numCNSS">
                    </v-text-field>
                  </div>
                </v-flex>
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="N° Impot" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numImpot">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="N° Compte Bancaire" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numcpteBanque">
                    </v-text-field>
                  </div>
                </v-flex>
    
    
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList"
                      item-text="nom_banque" item-value="nom_banque" dense outlined
                      v-model="svData.BanqueAgant" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="Autres Détails" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autresDetail">
                    </v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Etat du Contrat" :items="[
                                { designation: 'Encours' },
                                { designation: 'Retraite' },
                                { designation: 'Revocation' },
                                { designation: 'Congé Technique' }
                              ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                dense item-text="designation" item-value="designation"
                                v-model="svData.etat_contrat"></v-autocomplete>
                            </div>
                          </v-flex>
    
              </v-layout>
    
    
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
              <v-btn color="  blue" dark :loading="loading" @click="validate">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
    
      <br /><br />
      <v-layout>
        <!--   -->
        <v-flex md12 :loading="loading">
          <v-layout>
            <v-flex md1>
            <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                      <span v-bind="attrs" v-on="on">
                            <v-btn :loading="loading" fab @click="fetchDataList">
                                <v-icon>autorenew</v-icon>
                                </v-btn>
                            </span>
                  </template>
                  <span>Initialiser</span>
            </v-tooltip>
        </v-flex>| formatDate
            <v-flex md6>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                clearable></v-text-field>
            </v-flex>
            <v-flex md5>
              <div>
                <!-- {{ this.don }} -->
              </div>
            </v-flex>
            <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <!-- <v-btn @click="dialog = true" fab color="  blue" dark>
                      <v-icon>add</v-icon>
                    </v-btn> -->
                  </span>
                </template>
                <span>Ajouter le Detail</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
          <br />
          <v-card :loading="loading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                <thead>
                <tr>
                  <th class="text-left">Agent</th>
                  <!-- <th class="text-left">TrypeContrat</th>
                  <th class="text-left">Poste</th>
                  <th class="text-left">LieuAffect</th>
                  <th class="text-left">Mutuelle</th> -->
                  <th class="text-left">DateDebutContrat</th>
                  <th class="text-left">DateFinContrat</th>
                  <th class="text-left">DateEssaie</th>
                  <th class="text-left">DateFinEssaie</th>
                  <th class="text-left">DuréeTotale</th>
                  <th class="text-left">DuréeRestante</th>
                  <th class="text-left">Congé</th>
                  <th class="text-left">Contrat</th>
                  <th class="text-left">MvtContrat</th>
                  <th class="text-left">Action</th>
                </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.noms_agent }}</td>
                    <!-- <td>{{ item.nom_contrat }}</td>
                    <td>{{ item.nom_poste }}</td>
                    <td>{{ item.nom_lieu }}</td>
                    <td>{{ item.nom_mutuelle }}</td> -->
                    <td>{{ item.dateAffectation }}</td>
                    <td>{{ item.dateFin | formatDate}}</td>
                    <td>{{ item.dateDebutEssaie | formatDate}}</td>
                    <td>{{ item.dateFinEssaie | formatDate}}</td>
                    <td>{{ item.dureecontrat| formatDate }}</td>
                    <td>{{ item.dureerestante | formatDate}}</td>
                    <td>
                        <v-btn
                            elevation="2"
                            x-small
                            class="white--text"
                            :color="item.conge == 'NON' ? '#3DA60C' : item.conge <= 'OUI' ? '#F13D17' :'error'"
                            depressed                            
                            >
                          {{ item.conge == 'NON' ? 'Actif' : item.conge == 'OUI' ? 'Congé' :'error' }}
                        </v-btn>
                    </td>
                    <td>
                        <v-btn
                            elevation="2"
                            x-small
                            class="white--text"
                            :color="item.dureerestante > 1 ? '#3DA60C' : item.dureerestante <= 1 ? '#F13D17' :'error'"
                            depressed                            
                            >
                          {{ item.dureerestante > 1 ? 'Encours' : item.dureerestante <= 1 ? 'Fin Contrat' :'error' }}
                        </v-btn>
                    </td>
                    <td>
                    <v-btn elevation="2" x-small class="white--text"
                        :color="item.etat_contrat == 'Encours' ? '#3DA60C' : 'error'"
                        depressed>
                        {{ item.etat_contrat }} </v-btn>
                  </td>
                    <td>

                      <v-menu bottom rounded offset-y transition="scale-transition">
                        <template v-slot:activator="{ on }">
                          <v-btn icon v-on="on" small fab depressed text>
                            <v-icon>more_vert</v-icon>
                          </v-btn>
                        </template>

                        <v-list dense width="">

                          <v-list-item link @click="showAvanceSurSalaire(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Avance sur Salaire
                            </v-list-item-title>
                          </v-list-item>

                          <v-list-item link @click="showAppreciationAgent(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Appreciations sur l'Agent
                            </v-list-item-title>
                          </v-list-item>

                          <v-list-item link @click="showDemandeConge(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Demande de Congé
                            </v-list-item-title>
                          </v-list-item>

                          <!-- <v-list-item link @click="showControleConge(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Congé annuel(Nombre)
                            </v-list-item-title>
                          </v-list-item> -->

                          <v-list-item link @click="showDemandeSoinAgent(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Demande de soin Medicaux
                            </v-list-item-title>
                          </v-list-item>

                          <v-list-item link @click="showDemandeSortieAgent(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Demande de sortie
                            </v-list-item-title>
                          </v-list-item>

                          <!-- showDemandeConge -->

                          


                          <!-- <v-list-item link @click="showEnteteConge(item.id, item.noms_agent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Demande de Congé
                            </v-list-item-title>
                          </v-list-item> -->

                          <v-list-item link
                            @click="showDetailAffectationRubrique(item.id, item.noms_agent, item.refCategorieAgent)">
                            <v-list-item-icon>
                              <v-icon color="  blue">description</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Les Rubriques Salariales
                            </v-list-item-title>
                          </v-list-item>

                          <v-list-item link @click="editData(item.id)">
                            <v-list-item-icon>
                              <v-icon color="  blue">edit</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Modifier
                            </v-list-item-title>
                          </v-list-item>
                         

                          <!-- <v-list-item   link @click="deleteData(item.id)">
                            <v-list-item-icon>
                              <v-icon color="  red">delete</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Supprimer
                            </v-list-item-title>
                          </v-list-item> -->

                        </v-list>


                      </v-menu>


                    </td>
                  </tr>
                </tbody>
                </template>
              </v-simple-table>
              <hr />
    
              <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                @input="fetchDataList"></v-pagination>
            </v-card-text>
          </v-card>
        </v-flex>
    
      </v-layout>
    </v-flex>
    
    </v-layout>
    
    </div>
       
      </template>
      <script>
      import { mapGetters, mapActions } from "vuex";
      import AppreciationAgent from './AppreciationAgent.vue';
      import AvanceSurSalaire from './AvanceSurSalaire.vue';
      import ControleConge from './ControleConge.vue';
      import DemandeSoinAgent from './DemandeSoinAgent.vue';
      import DemandeSortieAgent from './DemandeSortieAgent.vue';
      import DetailAffectationRubrique from './DetailAffectationRubrique.vue';
      import EnteteConge from './EnteteConge.vue';
      import DemandeConge from "./DemandeConge.vue";
      
      
      
      export default {
        components: {
          AppreciationAgent,
          ControleConge,
          DemandeSoinAgent,
          DemandeSortieAgent,
          EnteteConge,
          DetailAffectationRubrique,
          AvanceSurSalaire,
          DemandeConge
        },
        data() {
          return {
      
            title: "Liste des Details",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,
            etatModal: false,
            titleComponent: '',
            refAgent: 0,
            //// 
      
            //  id ,'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            // 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            // 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            // 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            // 'BanqueAgant','autresDetail','conge','author'
      
            svData: {
              id: '',
              refAgent: 0,
              refServicePerso: 0,
              refCategorieAgent: 0,
              dateAffectation: '',
      
              refPoste: 0,
              refLieuAffectation: 0,
              refMutuelle: 0,
              refTypeContrat: 0,
              dureecontrat: 0,
              dureeLettre: '',
              dateDebutEssaie: '',
              dateFinEssaie: '',
              JourTrail1: '',
              JourTrail2: '',
              heureTrail1: '',
              heureTrail2: '',
              TempsPause: '',
              nbrConge: 0,
              nbrCongeLettre: '',
              nomOffice: '',
              postnomOffice: '',
              qualifieOffice: '',
              directeur: '',
      
              codeAgent: '',
              numCNSS: '',
              numImpot: '',
              numcpteBanque: '',
              BanqueAgant: '',
              autresDetail: '',
              etat_contrat:'',
              author: "Admin",
            },
            fetchData: [],
            serviceList: [],
            categorieList: [],
            agentList: [],
      
            lieuList: [],
            postList: [],
            mutuelleList: [],
            contratList: [],
      
            BanqueList: [],
            don: [],
            query: "",
      
            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''
      
          }
        },
        created() {
      
          this.fetchDataList();
          this.fetchListService();
          this.fetchListCategorie();
          this.fetchListMutuelle();
          this.fetchListPoste();
          this.fetchListLieuAffectation();
          this.fetchListContrat();
          this.fetchListAgent();
          this.get_Banque();
        },
        computed: {
          ...mapGetters(["categoryList", "isloading"]),
        },
        methods: {
      
          ...mapActions(["getCategory"]),
      
          validate() {
            if (this.$refs.form.validate()) {
              this.isLoading(true);
              if (this.edit) {
                this.svData.refAgent = this.refAgent;
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                  `${this.apiBaseURL}/update_AffectationAgent/${this.svData.id}`,
                  JSON.stringify(this.svData)
                )
                  .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog = false;
                    this.resetObj(this.svData);
                    this.fetchDataList();
                  })
                  .catch((err) => {
                    this.svErr(), this.isLoading(false);
                  });
      
              }
              else {
                this.svData.refAgent = this.refAgent;
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                  `${this.apiBaseURL}/insert_AffectationAgent`,
                  JSON.stringify(this.svData)
                )
                  .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog = false;
                    this.resetObj(this.svData);
                    this.fetchDataList();
                  })
                  .catch((err) => {
                    this.svErr(), this.isLoading(false);
                  });
              }
      
            }
          },
      
        fetchListAgent() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
            ({ data }) => {
              var donnees = data.data;
              this.agentList = donnees;
      
            }
          );
      
        },
          editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_AffectationAgent/${id}`).then(
              ({ data }) => {
                 this.titleComponent = "modification des informations";
                 
                 this.getSvData(this.svData, data[0]);
                this.edit = true;
                this.dialog = true;
              }
            );
          },
          deleteData(id) {
            this.confirmMsg().then(({ res }) => {
              this.delGlobal(`${this.apiBaseURL}/delete_AffectationAgent/${id}`).then(
                ({ data }) => {
                  this.showMsg(data.data);
                  this.fetchDataList();
                }
              );
            });
          },
      
          printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
          },
          fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/contrat_encours?page=`);
          },
      
          fetchListService() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel2`).then(
              ({ data }) => {
                var donnees = data.data;
                this.serviceList = donnees;
              }
            );
          },
          fetchListCategorie() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_categorie_agent`).then(
              ({ data }) => {
                var donnees = data.data;
                this.categorieList = donnees;
              }
            );
          },
          fetchListMutuelle() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_mutuelle_pers`).then(
              ({ data }) => {
                var donnees = data.data;
                this.mutuelleList = donnees;
              }
            );
          },
          fetchListPoste() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_poste_pers`).then(
              ({ data }) => {
                var donnees = data.data;
                this.postList = donnees;
              }
            );
          },
          fetchListContrat() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_typecontrat_pers`).then(
              ({ data }) => {
                var donnees = data.data;
                this.contratList = donnees;
              }
            );
          },
          fetchListLieuAffectation() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_lieuaffectation_pers`).then(
              ({ data }) => {
                var donnees = data.data;
                this.lieuList = donnees;
              }
            );
          },
          showAppreciationAgent(refAffectation, name) {
      
            if (refAffectation != '') {
      
              this.$refs.AppreciationAgent.$data.etatModal = true;
              this.$refs.AppreciationAgent.$data.refAffectation = refAffectation;
              this.$refs.AppreciationAgent.$data.svData.refAffectation = refAffectation;
              this.$refs.AppreciationAgent.fetchDataList();
              this.$refs.AppreciationAgent.fetchListSelection();
              this.fetchDataList();
      
              this.$refs.AppreciationAgent.$data.titleComponent =
                "Appreciation pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
      
          },
          showControleConge(refAffectation, name) {
      
            if (refAffectation != '') {
      
              this.$refs.ControleConge.$data.etatModal = true;
              this.$refs.ControleConge.$data.refAffectation = refAffectation;
              this.$refs.ControleConge.$data.svData.refAffectation = refAffectation;
              this.$refs.ControleConge.fetchDataList();
              this.$refs.ControleConge.fetchListSelection();
              this.fetchDataList();
      
              this.$refs.ControleConge.$data.titleComponent =
                "Controle de Congé annuel pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          showAvanceSurSalaire(refAffectation, name) {
      
            if (refAffectation != '') {
      
              this.$refs.AvanceSurSalaire.$data.etatModal = true;
              this.$refs.AvanceSurSalaire.$data.refAffectation = refAffectation;
              this.$refs.AvanceSurSalaire.$data.svData.refAffectation = refAffectation;
              this.$refs.AvanceSurSalaire.fetchDataList();
              this.$refs.AvanceSurSalaire.fetchListSelection();
              this.$refs.AvanceSurSalaire.fetchListMois();
              this.fetchDataList();
      
              this.$refs.AvanceSurSalaire.$data.titleComponent =
                "Avance sur Salaire pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          showDemandeConge(affectation_id, name) {
      
            if (affectation_id != '') {
      
              this.$refs.DemandeConge.$data.etatModal = true;
              this.$refs.DemandeConge.$data.affectation_id = affectation_id;
              this.$refs.DemandeConge.$data.svData.affectation_id = affectation_id;
              this.$refs.DemandeConge.fetchDataList();
              this.$refs.DemandeConge.fetchListAnnee();
              this.$refs.DemandeConge.fetchListAgent();
              this.$refs.DemandeConge.fetchListCategorieCirconstance();
              this.fetchDataList();
      
              this.$refs.DemandeConge.$data.titleComponent =
                "Démande de congé pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          showDemandeSoinAgent(refAffectation, name) {
      
            if (refAffectation != '') {
      
              this.$refs.DemandeSoinAgent.$data.etatModal = true;
              this.$refs.DemandeSoinAgent.$data.refAffectation = refAffectation;
              this.$refs.DemandeSoinAgent.$data.svData.refAffectation = refAffectation;
              this.$refs.DemandeSoinAgent.fetchDataList();
              this.$refs.DemandeSoinAgent.fetchListSelection();
              this.$refs.DemandeSoinAgent.fetchListSAnnee();
              this.$refs.DemandeSoinAgent.fetchListMois();
              this.fetchDataList();
      
              this.$refs.DemandeSoinAgent.$data.titleComponent =
                "Demande de soin pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          showDemandeSortieAgent(refAffectation, name) {
      
            if (refAffectation != '') {
      
              this.$refs.DemandeSortieAgent.$data.etatModal = true;
              this.$refs.DemandeSortieAgent.$data.refAffectation = refAffectation;
              this.$refs.DemandeSortieAgent.$data.svData.refAffectation = refAffectation;
              this.$refs.DemandeSortieAgent.fetchDataList();
              this.$refs.DemandeSortieAgent.fetchListSelection();
              this.fetchDataList();
      
              this.$refs.DemandeSortieAgent.$data.titleComponent =
                "Demande de sortie pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          showEnteteConge(refAffectation, name) {
      
            if (refAffectation != '') {
      
              this.$refs.EnteteConge.$data.etatModal = true;
              this.$refs.EnteteConge.$data.refAffectation = refAffectation;
              this.$refs.EnteteConge.$data.svData.refAffectation = refAffectation;
              this.$refs.EnteteConge.fetchDataList();
              this.$refs.EnteteConge.fetchListAnnee();
              this.$refs.EnteteConge.fetchListAgent();
              this.$refs.EnteteConge.fetchDataList();
      
              this.$refs.EnteteConge.$data.titleComponent =
                "Congé pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          showDetailAffectationRubrique(refAffectation, name, refCategorieAgent) {
      
            if (refAffectation != '') {
      
              this.$refs.DetailAffectationRubrique.$data.etatModal = true;
              this.$refs.DetailAffectationRubrique.$data.refAffectation = refAffectation;
              this.$refs.DetailAffectationRubrique.$data.refCategorieAgent = refCategorieAgent;
              this.$refs.DetailAffectationRubrique.$data.svData.refAffectation = refAffectation;
              this.$refs.DetailAffectationRubrique.fetchDataList();
              this.$refs.DetailAffectationRubrique.fetchListSelection();
              this.$refs.DetailAffectationRubrique.$data.titleComponent =
                "Affectation Rubrique de Paiement pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
          },
          async get_Banque() {
            this.isLoading(true);
            await axios
              .get(`${this.apiBaseURL}/fetch_tconf_banque_2`)
              .then((res) => {
                var chart = res.data.data;
                if (chart) {
                  this.BanqueList = chart;
                } else {
                  this.BanqueList = [];
                }
      
                this.isLoading(false);
      
                //   console.log(this.stataData.car_optionList);
              })
              .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
              });
          },
          desactiverData(valeurs, user_created, date_entree, noms) {
            //
            var tables = 'tclient';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression d'un patient au nom de : " + noms + " par l'utilisateur " + user_name + "";
      
            this.confirmMsg().then(({ res }) => {
              this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
                ({ data }) => {
                  this.showMsg(data.data);
                  this.onPageChange();
                }
              );
            });
          }
      
          //fetchListCategorie
        },
        filters: {
      
        }
      }
      </script>