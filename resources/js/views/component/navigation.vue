<template>
  <div>

    <div class="text-center mt-5">

      <v-avatar class="my-5" size="60">

        <!-- <img 
            :src="userData.avatar== null
                ? `${baseURL}/images/avatar.png`
                : `${baseURL}/images/` + userData.avatar
            "
           class="image" /> -->

        <img :src="userData.avatar == null
          ? `${baseURL}/images/logo.png`
          : `${baseURL}/images/logo.png`
          " class="image" />

      </v-avatar>
      <strong>
        <!-- <h5>{{ userData.name }}</h5> -->
        <h5>HOTEL</h5>
      </strong>

      <!-- <h6 class="grey--text ">{{ userData.email }}</h6> -->
      <h6 class="grey--text ">Connected : {{ userData.name }}</h6>
      <v-btn rounded color="#2EBFAF" outlined>Se mettre à jour</v-btn>

    </div>
    <v-divider class="mx-10 mt-3"></v-divider>

    <v-list dense nav shaped>
      <!-- mes menus -->

      <!-- test -->
      <v-list>
        <v-list-item-group color="primary">
          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links" :key="link.text" :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-icon v-bind="attrs" v-on="on">
                  <v-icon>{{ link.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <!-- fin -->

      <v-divider></v-divider>

      <v-list nav dense style="margin-bottom: -18px;">

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listGroup" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listCommancdes" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listAppro" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listVentes" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->


     <!-- liste groupe -->
     <v-list-group v-for="list in linkAdmin.listFactureGroup" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->


      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listUsage" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listCmdCuisine" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

       <!-- liste groupe -->
       <v-list-group v-for="list in linkAdmin.listInventaire" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listPersonnel" :key="list.id" :value="false" no-action group>
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->


    <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listPresence" :key="list.id" :value="false" no-action group>
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
    <!-- fin liste groupe -->

        <!-- liste groupe -->
        <v-list-group v-for="list in linkAdmin.listCorresp" :key="list.id" :value="false" no-action group>
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
    <!-- fin liste groupe -->

    <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listTimeSheet" :key="list.id" :value="false" no-action group>
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
    <!-- fin liste groupe -->


      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listArchivages" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->


      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listProjets" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listReservations" :key="list.id" :value="false" no-action group 
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listFinances" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listBillards" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listLogistique" :key="list.id" :value="false" no-action group
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->



      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listVehicules" :key="list.id" :value="false" no-action group 
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->


      <!-- liste groupe -->
      <v-list-group v-for="list in linkAdmin.listSalon" :key="list.id" :value="false" no-action group 
      >
        <template v-slot:activator>
          <v-list-item-icon>
            <v-icon>{{ list.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-title>{{ list.text }}</v-list-item-title>
        </template>

        <v-list-item-group>
          <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              <span>{{ submenu.text }}</span>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>
      <!-- fin liste groupe -->

      <!-- script2 -->
      <v-list-group prepend-icon="settings">
        <template v-slot:activator>
          <v-list-item-title>Paramètre</v-list-item-title>
        </template>

        <!-- groupe 2 -->
        <v-list-group no-action sub-group v-show="linkAdmin.links_operation_2.length > 0" >
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Configuration</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation_2" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <!-- fin groupe 2 -->



        <!-- groupe 2 -->
        <v-list-group no-action sub-group v-show="linkAdmin.links_finance.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Finance</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_finance" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <!-- fin groupe 2 -->


        <!--  -->
        <!-- groupe 2 -->
        <v-list-group no-action sub-group v-show="linkAdmin.links_personne.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>RH</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_personne" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <!-- fin groupe 2 -->


        <!-- groupe 2 -->
        <v-list-group no-action sub-group v-show="linkAdmin.links_vente.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Stock&Vente</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_vente" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <!-- fin groupe 2 -->




        <!-- groupe 2 -->
        <v-list-group no-action sub-group v-show="linkAdmin.links_tresorerie.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Trésorerie</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_tresorerie" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <!-- fin groupe 2 -->



        <!-- groupe 2 -->
        <v-list-group no-action sub-group v-show="linkAdmin.links_hotel.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Hotel</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_hotel" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <!-- fin groupe 2 -->




        <v-list-group no-action sub-group v-show="linkAdmin.links_operation.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Opération</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>



        <v-list-group no-action sub-group v-show="linkAdmin.links_systems.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Système</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_systems" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>
      </v-list-group>

      
      </v-list>


      <v-divider></v-divider>

      <v-list-item style="text-decoration: none" :href="`${this.baseURL}/logout`">
        <v-list-item-action>
          <v-icon>exit_to_app</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Déconnexion</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <!-- fin scripts -->
    </v-list>
  </div>
</template>

<script>
import userImage from './userImage.vue';
export default {
  props: ['linkAdmin'],
  components: {
    userImage,
  },
  data() {
    return {
      titre: "",
      // menuList: []
    }

  },
  methods: {
    // fetchMenu() {
    //   this.editOrFetch(`${this.apiBaseURL}/fetch_menu_roles/${this.userData.id_role}`).then(
    //     ({ data }) => {
    //       var donnees = data.data;
    //       this.menuList = donnees;
    //       console.log(donnees);
    //     }
    //   );
    // }
  },
  created() {
    //this.fetchMenu();
  },

}
</script>

<style scoped>
#navimg {
  background-image: url("./zzz.jpg");
  width: 100%;
  height: 140px;
}
</style>
