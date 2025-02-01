<template>
    <v-row justify="center"> 

  
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!-- DetailAffectationRubrique -->
  
          <v-card-title class="primary">
            {{ titleComponent }} <v-spacer></v-spacer>
            <v-btn depressed text small fab @click="etatModal = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <!-- layout -->
  
            <div>
  
              <v-layout>
  
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="800px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Check list pour l'Agent <v-spacer></v-spacer>
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

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              1. Les documents ci-dessous ont-ils été joints au dossier du personnel
                            </v-input>
                          </div>
                        </v-flex>
                    

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Check List/Fiche individuelle du personnel" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.checklist">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Lettre de motivation/Demande d'emploi" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.motivation">
                               </v-select>
                            </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Curriculum Vitae à jour" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.cv">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Copies des diplomes obtenus" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.diplome">
                               </v-select>
                            </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Copie de la carte d'identité" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.carteidentite">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Acte de naissance de l'agent" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.actenaissance">
                               </v-select>
                            </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Acte de naissance de chaque enfant" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.actenaissanceenfant">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Certificat d'aptitude physique de l'agent" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.aptitudephysique">
                               </v-select>
                            </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Attestation de bonne vie et moeurs" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.viemoeurs">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Attestation de services rendus(ancien employeur)" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.servicerendu">
                               </v-select>
                            </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Fiche d'identification individuelle + photo de l'agent" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.ficheidentite">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Copie du contrat de travail" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.contrattravail">
                               </v-select>
                            </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Copie de description des taches(Job description)" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.jobdescription">
                               </v-select>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Acte de mariage ou attestation de celibat" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.actemariage">
                               </v-select>
                            </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              II. ACCUEIL ET INDUCTION
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Briefing sur le role de la Caritas Goma et ses missions, visions, valeurs?" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.briefingmission">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datebriefingmission">
                                </v-text-field>
                              </div>
                        </v-flex> 


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Connaissance de l'Organigramme" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.organigramme">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.dateorganigramme">
                                </v-text-field>
                              </div>
                        </v-flex> 


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Briefing sur le role et attentes du poste" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.briefingposte">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datebriefingposte">
                                </v-text-field>
                              </div>
                        </v-flex> 


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Presentation du plan strategique ?" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.planstrategique">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.dateplanstrategique">
                                </v-text-field>
                              </div>
                        </v-flex> 


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Briefing sur les regles de bonne gestion" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.briefinggestion">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datebriefinggestion">
                                </v-text-field>
                              </div>
                        </v-flex>
                        
                        
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Presentation du manuel de gestion des procedures" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.mannuel">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datemannuel">
                                </v-text-field>
                              </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Evaluation du staff prévu" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.evaluationstaff">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date A)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datestaff1">
                                </v-text-field>
                              </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date B)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datestaff2">
                                </v-text-field>
                              </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date C)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datestaff3">
                                </v-text-field>
                              </div>
                        </v-flex>





                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Périodes prévues congés staff ?" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.periodeconge">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date Congé A)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.dateconge1">
                                </v-text-field>
                              </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date Congé B)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.dateconge2">
                                </v-text-field>
                              </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date Congé C)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.dateconge3">
                                </v-text-field>
                              </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Biefing sur la securité ?" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.briefingsecurite">
                               </v-select>
                            </div>
                        </v-flex>  
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date Congé A)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datebriefingsecurite">
                                </v-text-field>
                              </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              III. FIN DE CONTRAT (à remplir à un moment de départ du staff)
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                               <v-select label="Lettre de notification en vacance avec copie de l'Admin Financier et Logistique ?" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.notification">
                               </v-select>
                            </div>
                        </v-flex> 
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Note de finances indiquant le solde" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.notefinance">
                               </v-select>
                            </div>
                        </v-flex> 

                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.datenotefinance">
                                </v-text-field>
                              </div>
                        </v-flex>





                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                               <v-select label="Attestation de services ?" :items="[
                                    { designation: 'OUI' },
                                    { designation: 'NON' }]" 
                                  prepend-inner-icon="extension"
                                   outlined dense
                                  item-text="designation" item-value="designation"
                                  v-model="svData.attesteservice">
                               </v-select>
                            </div>
                        </v-flex> 
                        <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Si Oui, quelles dates/periode ?" prepend-inner-icon="event" dense
                                   outlined v-model="svData.dateattesteservice">
                                </v-text-field>
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
                    <v-flex md12>
                      <v-layout>
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
                                <v-btn @click="dialog = true" fab color="  blue" dark>
                                  <v-icon>add</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Ajouter le Detail</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                      <br />
                      <v-card>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th class="text-left">Agent</th>
                                  <th class="text-left">CheckList</th>
                                  <th class="text-left">CV</th>
                                  <th class="text-left">Diplome</th>
                                  <th class="text-left">CarteIdentite</th>
                                  <th class="text-left">CopieContrat</th>
                                  <th class="text-left">JobDescription</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms_agent }}$</td>
                                  <td>
                                    <v-btn elevation="2" x-small class="white--text"
                                                :color="item.checklist == 'NON' ? '#F13D17' : item.checklist == 'OUI' ? '#3DA60C' : 'error'"
                                                depressed>
                                                {{ item.checklist == 'NON' ? 'Attente' : item.checklist == 'OUI' ? 'Validé': item.checklist == null ? 'Attente' : 'error' }}
                                    </v-btn>
                                  </td>
                                  <td>
                                    <v-btn elevation="2" x-small class="white--text"
                                        :color="item.cv == 'NON' ? '#F13D17' : item.cv == 'OUI' ? '#3DA60C' : 'error'"
                                        depressed>
                                        {{ item.cv == 'NON' ? 'Attente' : item.cv ==
                                        'OUI' ? 'Validé': item.cv == null ? 'Attente' : 'error' }}
                                    </v-btn>
                                  </td>
                                  <td>
                                    <v-btn elevation="2" x-small class="white--text"
                                        :color="item.diplome == 'NON' ? '#F13D17' : item.diplome == 'OUI' ? '#3DA60C' : 'error'"
                                        depressed>
                                        {{ item.diplome == 'NON' ? 'Attente' : item.diplome ==
                                        'OUI' ? 'Validé' : item.diplome == null ? 'Attente' : 'error' }}
                                    </v-btn>
                                  </td>
                                  <td>
                                    <v-btn elevation="2" x-small class="white--text"
                                        :color="item.carteidentite == 'NON' ? '#F13D17' : item.carteidentite == 'OUI' ? '#3DA60C' : 'error'"
                                        depressed>
                                        {{ item.carteidentite == 'NON' ? 'Attente' : item.carteidentite ==
                                        'OUI' ? 'Validé' : item.carteidentite == null ? 'Attente' : 'error' }}
                                    </v-btn>
                                  </td>
                                  <td>
                                    <v-btn elevation="2" x-small class="white--text"
                                        :color="item.contrattravail == 'NON' ? '#F13D17' : item.contrattravail == 'OUI' ? '#3DA60C' : 'error'"
                                        depressed>
                                        {{ item.contrattravail == 'NON' ? 'Attente' : item.contrattravail ==
                                        'OUI' ? 'Validé' : item.contrattravail == null ? 'Attente' : 'error' }}
                                    </v-btn>
                                  </td>
                                  <td>
                                    <v-btn elevation="2" x-small class="white--text"
                                        :color="item.jobdescription == 'NON' ? '#F13D17' : item.jobdescription == 'OUI' ? '#3DA60C' : 'error'"
                                        depressed>
                                        {{ item.jobdescription == 'NON' ? 'Attente' : item.jobdescription ==
                                        'OUI' ? 'Validé' : item.jobdescription == null ? 'Attente' : 'error' }}
                                    </v-btn>
                                  </td>
                                  <td>{{ item.author }}</td>
                                  <td>  
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                      <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn>
                                      </template>
  
                                      <v-list dense width="">
   
                                        <v-list-item link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier
                                          </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="printBill(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="blue">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Imprimer CheckList
                                          </v-list-item-title>
                                        </v-list-item>
  
                                        <v-list-item  link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="red">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Supprimer
                                          </v-list-item-title>
                                        </v-list-item>
  
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
  
  
            <!-- fin -->
          </v-card-text>
  
          <!-- container -->
        </v-card>
      </v-dialog>
    </v-row>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";  
  
  export default {
    components: {

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
        //  'id','refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
        // 'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
        // 'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
        // 'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
        // 'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
        // 'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
        // 'dateattesteservice'  
        //            //,'periodeconge','dateconge1','dateconge2','dateconge3'
        svData: {
            id: '',
            refAgent: 0,
            checklist:"",
            motivation:"",
            cv:"",
            diplome:"",
            carteidentite:"",
            actenaissance:"",
            actenaissanceenfant:"",
            aptitudephysique:"",
            viemoeurs:"",
            servicerendu:"",
            ficheidentite:"",
            contrattravail:"",
            jobdescription:"",
            actemariage:"",
            briefingmission:"",
            datebriefingmission : null,
            organigramme:"",
            dateorganigramme : null,
            briefingposte:"",
            datebriefingposte: null,
            planstrategique:"",
            dateplanstrategique: null,
            briefinggestion:"",
            datebriefinggestion: null,
            mannuel:"",
            datemannuel: null,
            evaluationstaff:"",
            datestaff1: null,
            datestaff2: null,
            datestaff3: null,
            periodeconge:"",
            dateconge1: null,
            dateconge2: null,
            dateconge3: null,
            briefingsecurite:"",
            datebriefingsecurite: null,
            notification:"",
            notefinance:"",
            datenotefinance: null,
            attesteservice:"",
            dateattesteservice: null,          
            author: "",
        },
        fetchData: [],
        don: [],
        query: "",
  
        inserer: '',
        modifier: '',
        supprimer: '',
        chargement: ''  
      }
    },
    created() {  
      //this.fetchDataList();
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
              `${this.apiBaseURL}/update_checklist/${this.svData.id}`,
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
              `${this.apiBaseURL}/insert_checklist`,
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
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_checklist/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_checklist/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      }, 
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_checklist_agent?id=` + id);
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_checklist/${this.refAgent}?page=`);
      },
      desactiverData(valeurs, user_created, date_entree, noms) {
        //
        var tables = 'tchecklist';
        var user_name = this.userData.name;
        var user_id = this.userData.id;
        var detail_information = "Suppression d'un checklist au nom de : " + noms + " par l'utilisateur " + user_name + "";
  
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