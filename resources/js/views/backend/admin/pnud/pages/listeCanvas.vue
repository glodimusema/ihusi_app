<template>
    
    <div>

        <v-flex md12>
            <v-dialog
                v-model="dialog"
                max-width="600"
                hide-overlay
                transition="dialog-bottom-transition"
                persistent
            >
                <v-card :loading="loading">
                <v-form ref="form" lazy-validation>
                    <v-card-title class="text-h6 primary">
                    {{ titleComponent }} <v-spacer></v-spacer>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog = false" text fab depressed>
                            <v-icon>close</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Fermer</span>
                    </v-tooltip></v-card-title
                    >
                    <v-card-text max-height="1000px">
                    <v-container>
                        <v-layout row wrap class="mt-2">
                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                            <v-select
                                :items="ListeTitreCanvas"
                                label="Le titre comme valeur de l'indice"
                                prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                outlined
                                chips
                                dense
                                item-text="designation"
                                item-value="designation"
                                v-model="svData.titre"
                            ></v-select>
                            </div>
                        </v-flex>


                        <v-flex xs12 md12 sm12 lg12>
                            <div class="mr-1">
                                <v-textarea
                                    label="Le texte comme description de l'indice"
                                    rows="1"
                                    prepend-inner-icon="history_edu"
                                    outlined
                                    v-model="svData.message"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                    dense
                                    
                                ></v-textarea>
                            </div>
                        </v-flex>
                        </v-layout>
                    </v-container>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                    <v-btn color="primary" dark :loading="loading" @click="validate">
                        {{ edit ? "Modifier" : "Ajouter" }}
                    </v-btn>
                    </v-card-actions>
                </v-form>
                </v-card>
            </v-dialog>
           
            <v-layout>
                <v-layout>
                <v-flex md1></v-flex>
                <v-flex md10></v-flex>
                <v-flex md1></v-flex>
                </v-layout>

                <v-flex md12>
                <!-- bande -->
                <v-layout>
                    <v-flex md1>
                      <v-tooltip bottom>
                          <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                              <v-btn :loading="loading" fab @click="onPageChange">
                              <v-icon>autorenew</v-icon>
                              </v-btn>
                          </span>
                          </template>
                          <span>Initialiser</span>
                      </v-tooltip>
                    </v-flex>
                    &nbsp;&nbsp;&nbsp;
                    
                    <v-flex md1>
                      <v-tooltip bottom>
                          <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on" v-if="userData.id_role==1 ? true : false">
                              <v-btn  fab
                                link
                                :to="'/admin/canvas_entreprise_detail/' + projectDetail.slug" 
                              >
                              <v-icon>list</v-icon>
                              </v-btn>
                          </span>
                          <span v-bind="attrs" v-on="on" v-else>
                              <v-btn  fab
                                link
                                :to="'/user/canvas_entreprise_detail/' + projectDetail.slug" 
                              >
                              <v-icon>list</v-icon>
                              </v-btn>
                          </span>
                          </template>
                          <span>Le voir en grand</span>
                      </v-tooltip>
                    </v-flex>
                    <v-flex md1></v-flex>
                    <v-flex md7>
                      <div class="mt-2 mr-1 mb-1 text-center">
                        <h2>Model d'affaire canvas de {{projectDetail.nomEntreprise}}</h2>
                      </div>
                    </v-flex>

                    <v-flex md1></v-flex>

                    <v-flex md1>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="showModal" fab color="primary">
                            <v-icon>add</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Ajouter une opération</span>
                    </v-tooltip>
                    </v-flex>
                </v-layout> 
                <!-- bande -->
                <v-divider></v-divider>
                <br />

                

                
                <!-- les composants -->

                <v-card
                    :loading="loading"
                    class="mx-auto my-0"

                >
                    <v-card-text>
                
                        <div class="block galleryBlock">

                          <!-- list busnessModelcanvas -->
                          <table id="bizcanvas" cellspacing="0" border="1" 
                           >
                            <!-- Upper part -->
                            <tr>
                              <td colspan="2" rowspan="2">
                               <h4 @click="menuList = !menuList" style="cursor: pointer;">Problème</h4>
                               <!-- {{
                                  JSON.stringify(fetchData[0].listCanvasUser)
                                }}  -->
                                
                                <!-- canvas 1 -->
                                <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                  <div v-if="item.titre=='Problème'">
                                      
                                    <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                         <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                      <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false"  >
                                       <v-spacer> </v-spacer>
                                        <v-menu
                                          bottom
                                          rounded
                                          offset-y
                                          transition="scale-transition"
                                         
                                        >
                                          <template v-slot:activator="{ on }">
                                          <v-btn icon v-on="on" small fab depressed text>
                                              <v-icon>more_vert</v-icon>
                                          </v-btn>
                                          </template>

                                          <v-list dense width="">
                                              
                                              <v-list-item
                                                  
                                                  link
                                                  @click="editData(item2.id)"
                                                  
                                              >
                                                  <v-list-item-icon>
                                                      <v-icon>edit</v-icon>
                                                  </v-list-item-icon>
                                                  <v-list-item-title style="margin-left: -20px"
                                                  >Modifier</v-list-item-title
                                                  >
                                              </v-list-item>

                                              <v-list-item
                                                  
                                                  link
                                                  @click="clearP(item2.id)"
                                                  
                                              >
                                                  <v-list-item-icon>
                                                      <v-icon>delete</v-icon>
                                                  </v-list-item-icon>
                                                  <v-list-item-title style="margin-left: -20px"
                                                  >Supprimer</v-list-item-title
                                                  >
                                              </v-list-item>

                                          </v-list>
                                        </v-menu>
                                      </div>
                                     
                                    </div>

                                      


                                  </div>
                                  
                                 
                                </div>  
                                <!-- fin canvas 1 -->

                                <!-- canvas 1 -->
                                <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                  <div v-if="item.titre=='Problème'">
                                      
                                    <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                        <div color="text-red">
                                          
                                          <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                           <!-- menu popup -->
                                          <div class="mt-0">
                                            <v-menu
                                              :close-on-content-click="false"
                                              :nudge-width="200"
                                              offset-x
                                            >
                                              <template v-slot:activator="{ on, attrs }">
                                                <div v-bind="attrs" v-on="on">
                                                   <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                </div>
                                                
                                               
                                              </template>

                                              <v-card>
                                                <v-list>
                                                  <v-list-item>
                                                    <v-list-item-avatar>
                                                      <img
                                                        :src="
                                                          item2.avatar == null
                                                            ? `${baseURL}/images/avatar.png`
                                                            : `${baseURL}/images/` + item2.avatar
                                                        "
                                                      />
                                                    </v-list-item-avatar>

                                                    <v-list-item-content>
                                                      <v-list-item-title>{{
                                                        item2.name
                                                      }}</v-list-item-title>
                                                      <v-list-item-subtitle
                                                        >{{ item2.email }}
                                                      </v-list-item-subtitle>
                                                    </v-list-item-content>

                                                    <v-list-item-action>
                                                      <!-- menu -->
                                                      <v-spacer></v-spacer>

                                                      <v-menu bottom left>
                                                        <template v-slot:activator="{ on, attrs }">
                                                          <v-btn icon v-bind="attrs" v-on="on">
                                                            <v-icon>more_vert</v-icon>
                                                          </v-btn>
                                                        </template>

                                                        <v-list dense rounded>
                                                          <v-list-item
                                                            dense
                                                            
                                                          >
                                                            <v-list-item-title>
                                                              <v-icon>today</v-icon>
                                                              {{ item2.created_at | formatDate }}
                                                              {{ item2.created_at | formatHour }}
                                                            </v-list-item-title>
                                                          </v-list-item>
                                                          
                                                        </v-list>
                                                      </v-menu>
                                                      <!-- fin menu -->
                                                    </v-list-item-action>

                                                   
                                                  </v-list-item>
                                                </v-list>

                                                
                                               
                                              </v-card>
                                            </v-menu>
                                          </div>
                                          <!-- fin menu popup -->
                                        </div>

                                      <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                       <v-spacer> </v-spacer>
                                        <v-menu
                                          bottom
                                          rounded
                                          offset-y
                                          transition="scale-transition"
                                         
                                        >
                                          <template v-slot:activator="{ on }">
                                          <v-btn icon v-on="on" small fab depressed text>
                                              <v-icon>more_vert</v-icon>
                                          </v-btn>
                                          </template>

                                          <v-list dense width="">
                                              
                                              <v-list-item
                                                  
                                                  link
                                                  @click="editData(item2.id)"
                                                  
                                              >
                                                  <v-list-item-icon>
                                                      <v-icon>edit</v-icon>
                                                  </v-list-item-icon>
                                                  <v-list-item-title style="margin-left: -20px"
                                                  >Modifier</v-list-item-title
                                                  >
                                              </v-list-item>

                                              <v-list-item
                                                  
                                                  link
                                                  @click="clearP(item2.id)"
                                                  
                                              >
                                                  <v-list-item-icon>
                                                      <v-icon>delete</v-icon>
                                                  </v-list-item-icon>
                                                  <v-list-item-title style="margin-left: -20px"
                                                  >Supprimer</v-list-item-title
                                                  >
                                              </v-list-item>

                                          </v-list>
                                        </v-menu>
                                      </div>
                                     
                                    </div>

                                      


                                  </div>
                                  
                                 
                                </div>  
                                <!-- fin canvas 1 -->
                                
                                
                              </td>
                              <td colspan="2">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Solution</h4>
                                
                                 <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Solution'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                  <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Solution'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                                
                              </td>
                              <td colspan="2" rowspan="2">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Proposition de valeur unique</h4>
                                  <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Proposition de valeur unique'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                  <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Proposition de valeur unique'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                                
                              </td>
                              <td colspan="2">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Avantage déloyale</h4>
                                 <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Avantage déloyale'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                  <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Avantage déloyale'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                                
                              </td>
                              <td colspan="2" rowspan="2">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Segments de clients</h4>
                                 <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Segment de client'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                  <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Segment de client'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                               
                              </td>
                            </tr>

                            <!-- Lower part -->
                            <tr>
                              <td colspan="2">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Indicateurs Clés</h4>
                                 <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Indicateur'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                   <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Indicateur'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                               
                              </td>
                              <td colspan="2">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Canaux</h4>
                                 <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Canaux'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->

                                   <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Canaux'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                              
                              </td>
                            </tr>
                            <tr>
                              <td colspan="5">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Structure des coûts</h4>
                                <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Structure des coûts'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                   <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Structure des coûts'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                                
                              </td>
                              <td colspan="5">
                                <h4 @click="menuList = !menuList" style="cursor: pointer;">Sources de revenus</h4>
                                <!-- canvas 2 -->
                                  <div v-for="item in fetchData[0].listCanvasUser" :key="item.titre">
                                    <div v-if="item.titre=='Sources revenus'">
                                        
                                      <div v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                           <div class="my-2">
                                               - {{item2.message}}
                                             </div>

                                        <div class="text-muted"  v-show="userData.id_role==2 ? menuList : false">
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                   
                                  
                                  </div>  
                                  <!-- fin canvas 2 -->
                                  <!-- canvas 1 -->
                                  <div v-for="item in fetchData[0].listCanvasUserCorrection" :key="item.titre">
                                    <div v-if="item.titre=='Sources revenus'">
                                        
                                      <div class="text-red" v-for="item2 in item.ListRowCanvas" :key="item2.id">
                                          <div color="text-red">
                                            
                                            <!--  <div class="my-2">
                                               - {{item2.message}}
                                             </div> -->

                                            <!-- menu popup -->
                                            <div class="mt-0">
                                              <v-menu
                                                :close-on-content-click="false"
                                                :nudge-width="200"
                                                offset-x
                                              >
                                                <template v-slot:activator="{ on, attrs }">
                                                  <div v-bind="attrs" v-on="on">
                                                     <div class="my-2">
                                               - {{item2.message}}
                                             </div>
                                                  </div>
                                                  
                                                
                                                </template>

                                                <v-card>
                                                  <v-list>
                                                    <v-list-item>
                                                      <v-list-item-avatar>
                                                        <img
                                                          :src="
                                                            item2.avatar == null
                                                              ? `${baseURL}/images/avatar.png`
                                                              : `${baseURL}/images/` + item2.avatar
                                                          "
                                                        />
                                                      </v-list-item-avatar>

                                                      <v-list-item-content>
                                                        <v-list-item-title>{{
                                                          item2.name
                                                        }}</v-list-item-title>
                                                        <v-list-item-subtitle
                                                          >{{ item2.email }}
                                                        </v-list-item-subtitle>
                                                      </v-list-item-content>

                                                      <v-list-item-action>
                                                        <!-- menu -->
                                                        <v-spacer></v-spacer>

                                                        <v-menu bottom left>
                                                          <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                              <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                          </template>

                                                          <v-list dense rounded>
                                                            <v-list-item
                                                              dense
                                                              
                                                            >
                                                              <v-list-item-title>
                                                                <v-icon>today</v-icon>
                                                                {{ item2.created_at | formatDate }}
                                                                {{ item2.created_at | formatHour }}
                                                              </v-list-item-title>
                                                            </v-list-item>
                                                            
                                                          </v-list>
                                                        </v-menu>
                                                        <!-- fin menu -->
                                                      </v-list-item-action>

                                                    
                                                    </v-list-item>
                                                  </v-list>

                                                  
                                                
                                                </v-card>
                                              </v-menu>
                                            </div>
                                            <!-- fin menu popup -->
                                          </div>

                                        <div  v-show="userData.id_role==1 || userData.id_role==3 ? menuList : false"  >
                                        <v-spacer> </v-spacer>
                                          <v-menu
                                            bottom
                                            rounded
                                            offset-y
                                            transition="scale-transition"
                                          
                                          >
                                            <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            </template>

                                            <v-list dense width="">
                                                
                                                <v-list-item
                                                    
                                                    link
                                                    @click="editData(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Modifier</v-list-item-title
                                                    >
                                                </v-list-item>

                                                <v-list-item
                                                    
                                                    link
                                                    @click="clearP(item2.id)"
                                                    
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px"
                                                    >Supprimer</v-list-item-title
                                                    >
                                                </v-list-item>

                                            </v-list>
                                          </v-menu>
                                        </div>
                                      
                                      </div>

                                        


                                    </div>
                                    
                                  
                                  </div>  
                                  <!-- fin canvas 1 -->
                               
                               
                              </td>
                            </tr>
                          </table>
                          <!-- fin busnessModelCanvas -->
                            
                        </div>
                    
                    </v-card-text>

                
                </v-card>

                <!-- fin des composants -->
                </v-flex>
            </v-layout>

            
        </v-flex>


       
        
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Canvas from "./canvas.vue";

export default {
    components:{
      Canvas,
    },
    data(){
        return {
            header: "crud operation",
            titleComponent: "Ajout busness model canvas",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            style: {
                height: "0px",
            },
            svData: {
                id: "",
                ceo: "",
                titre: "",
                message: "",
                id_coach: "",

            },
            fetchData: null,
            titreModal: "",
            image: "",
            menuList: false,
           
        };

    },
    computed: {
    ...mapGetters(["basicList", "isloading","ListeTitreCanvas","ListeTitreSwot", "projectDetail",]),
  },
  methods: {
    ...mapActions(["getBasic"]),
    showCanvasModal(id) {
        this.$refs.Canvas.$data.dialog = true;
        this.$refs.Canvas.$data.svData.ceo = id;  
    },
    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Model d'affaire canvas ";
      this.edit = false;
      this.resetObj(this.svData);
    },
    

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification  Model d'affaire canvas";
        this.style.height = "0px";
      } else {
        this.titleComponent = "Ajout Model d'affaire canvas ";
        this.style.height = "0px";
      }
    },

    onPageChange() {
      
        var slug = this.$route.params.slug;
        this.loading = true;
        this.disabled = true;
        this.editOrFetch(`${this.apiBaseURL}/fetch_canvas_entreprise/${slug}`).then(
            ({ data }) => {
                var donnees = data.data;
                this.fetchData = donnees;
                
                /*
                donnees.map((item) => {
                    this.svData.id = item.id;
                    this.titleComponent = "Modification busness model canvas ";
                });
                */

                this.loading = false;
                this.disabled = false;

            }
        );

    },

    validate() {
        if (this.edit == false) {
              this.svData.ceo = this.projectDetail.id;
              this.svData.id_coach =this.userData.id;
        }
        if (this.$refs.form.validate()) {
        this.isLoading(true);
        var url = '';
        if (this.userData.id_role == 1 || this.userData.id_role ==3 ) {
           url = "insert_canvas_correction_entreprise";
        }
        else{
           url = "insert_canvas_entreprise";
        }

        this.insertOrUpdate(
          `${this.apiBaseURL}/${url}`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.$emit("initialisateur_data");

            this.dialog = false;


          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
        }
    },

    editData(id) {
      var url = '';
      if (this.userData.id_role == 1 || this.userData.id_role == 3 ) {
          url = "fetch_single_canvas_correction_entreprise";
      }
      else{
          url = "fetch_single_canvas_entreprise";
      }
      this.editOrFetch(`${this.apiBaseURL}/${url}/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.id = item.id;
            this.titleComponent = "Modification Model d'affaire canvas ";
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      var url = '';
      if (this.userData.id_role == 1 || this.userData.id_role == 3 ) {
          url = "delete_canvas_correction_entreprise";
      }
      else{
          url = "delete_canvas_entreprise";
      }
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/${url}/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
            this.$emit("initialisateur_data");
          }
        );
      });
    },

    chargement(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);

        
    },


    
  },
  created() {
    this.chargement();
    this.onPageChange();
    this.testTitle();

  },

}
</script>
<style scoped>
.link_pro{
    text-decoration: none;
}
.text-red{
  color: #E91E63;
  cursor: pointer;
}
</style>

