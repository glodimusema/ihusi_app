<template>

    <v-row justify="center">
        <v-dialog v-model="dialog2" persistent max-width="500px">
          <v-card>
            <!-- container -->
    
            <v-card-title class="primary">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-btn depressed text small fab @click="dialog2 = false">
                <v-icon>close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text v-if="test"  id="printMe">
              <!-- layout -->
    
              <div>

                <table cellpadding="0" cellspacing="0" border="0"
                style="border-width:0px;empty-cells:show;width:409px;height:560px;position:relative;">
                <tr>
                  <td style="width:0px;height:0px;"></td>
                  <td style="height:0px;width:8px;"></td>
                  <td style="height:0px;width:1px;"></td>
                  <td style="height:0px;width:1px;"></td>
                  <td style="height:0px;width:18px;"></td>
                  <td style="height:0px;width:16px;"></td>
                  <td style="height:0px;width:9px;"></td>
                  <td style="height:0px;width:14px;"></td>
                  <td style="height:0px;width:36px;"></td>
                  <td style="height:0px;width:38px;"></td>
                  <td style="height:0px;width:1px;"></td>
                  <td style="height:0px;width:5px;"></td>
                  <td style="height:0px;width:51px;"></td>
                  <td style="height:0px;width:26px;"></td>
                  <td style="height:0px;width:5px;"></td>
                  <td style="height:0px;width:82px;"></td>
                  <td style="height:0px;width:17px;"></td>
                  <td style="height:0px;width:1px;"></td>
                  <td style="height:0px;width:10px;"></td>
                  <td style="height:0px;width:70px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:23px;"></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:10px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:92px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs101A94F7" colspan="6" style="width:126px;height:92px;text-align:left;vertical-align:top;">
                    <div style="overflow:hidden;width:126px;height:92px;">
                      <img alt="logo maison" :src="`${baseURL}/fichier/logo.png`" style="width:126px;height:92px;" />
                    </div>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <!--  -->
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="13"
                    style="width:314px;height:22px;line-height:16px;text-align:center;vertical-align:middle;">{{
                      test.nomEntreprise }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="13"
                    style="width:314px;height:22px;line-height:16px;text-align:center;vertical-align:middle;">{{
                      test.adresseEntreprise }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="13"
                    style="width:314px;height:22px;line-height:16px;text-align:center;vertical-align:middle;">{{
                      test.telephoneEntreprise }} - {{ test.telephone }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="13"
                    style="width:314px;height:22px;line-height:16px;text-align:center;vertical-align:middle;">{{
                      test.emailEntreprise }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="13"
                    style="width:314px;height:22px;line-height:16px;text-align:center;vertical-align:middle;">
                    <nobr>N&#176;&nbsp;Impot&nbsp;:&nbsp;{{ test.rccm }}</nobr>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:4px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs5971619E" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs101A94F7" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:3px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:32px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs3A663619" colspan="6"
                    style="width:143px;height:32px;line-height:32px;text-align:left;vertical-align:middle;">
                    <nobr>FACTURE</nobr>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:6px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="6"
                    style="width:57px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>N&#176;&nbsp; Res.:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>00{{ entete.refReservation }}</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="6"
                    style="width:57px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Contact&nbsp;:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">{{
                      entete.contact }}</td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="5"
                    style="width:56px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Date Rés.&nbsp;:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>{{ entete.dateReservation }}</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="4"
                    style="width:55px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Date Entrée&nbsp;:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>{{ entete.date_entree }}</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="4"
                    style="width:55px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Date Sortie&nbsp;:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>{{ entete.date_sortie }}</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="4"
                    style="width:55px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Nbr. Jour&nbsp;:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>{{ entete.NombreJour }}</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csAA7EBA13" colspan="4"
                    style="width:55px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Montant Chambre&nbsp;:</nobr>
                  </td>
                  <td class="csAA7EBA13" colspan="10"
                    style="width:260px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>{{ entete.totalFactureChambre }}$</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:10px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td class="cs8A513397" colspan="6"
                    style="width:92px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">
                    <nobr>Designation</nobr>
                  </td>
                  <td class="cs8A513397"
                    style="width:36px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">
                    <nobr>Qt&#233;</nobr>
                  </td>
                  <td class="cs8BD51C12" colspan="4"
                    style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">
                    <nobr>PU</nobr>
                  </td>
                  <td class="csA803F7DA" colspan="4"
                    style="width:101px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">
                    <nobr>PT</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:8px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs5971619E" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs101A94F7" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;" v-for="(donnee, index) in donneesvente" :key="index">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csCE72709D" colspan="5"
                    style="width:91px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">{{
                      donnee.designation }}</td>
                  <td class="cs38AECAED" colspan="2"
                    style="width:35px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">
                    <nobr>{{ donnee.qteVente }}</nobr>
                  </td>
                  <td class="cs38AECAED" colspan="3"
                    style="width:78px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">
                    <nobr>{{ donnee.puVente }}$</nobr>
                  </td>
                  <td class="cs38AECAED" colspan="4"
                    style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">
                    <nobr>{{ donnee.PTVente }}$</nobr>
                  </td>                  
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:9px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs5971619E" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs101A94F7" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:10px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csEF71EB8E" colspan="6"
                    style="width:101px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Total HT($)</nobr>
                  </td>
                  <td class="csA2F7C04E" colspan="6"
                    style="width:178px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">
                    <nobr>{{ entete.totalFacture }}$</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="csEF71EB8E" colspan="6"
                    style="width:101px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr></nobr>
                  </td>
                  <td class="csA2F7C04E" colspan="6"
                    style="width:178px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">
                    <nobr></nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>                  
                  <td class="csEF71EB8E" colspan="6"
                    style="width:101px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>TVA&nbsp;(USD)</nobr>
                  </td>
                  <td class="csA2F7C04E" colspan="6"
                    style="width:178px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">
                    <nobr>{{ entete.TotalTVA }}$</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>                  
                  <td class="csEF71EB8E" colspan="6"
                    style="width:101px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>A&nbsp;Payer&nbsp;Conso.</nobr>
                  </td>
                  <td class="csA2F7C04E" colspan="6"
                    style="width:178px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">
                    <nobr>{{ entete.PTTTC }}$</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>                  
                  <td class="csEF71EB8E" colspan="6"
                    style="width:101px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">
                    <nobr>Total Général(USD)</nobr>
                  </td>
                  <td class="csA2F7C04E" colspan="6"
                    style="width:178px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">
                    <nobr>{{ entete.TotalGeneral }}$</nobr>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <!-- TotalVenteUSD -->
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:11px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs5971619E" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:1px;"></td>
                  <td class="cs101A94F7" colspan="18" style="width:339px;height:1px;">
                    <!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:4px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>                
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="11"
                    style="width:279px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">
                    <nobr>Fait le {{ entete.created_at | formatDate }}
                                  {{ entete.created_at | formatHour }}
                                </nobr>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="vertical-align:top;">
                  <td style="width:0px;height:22px;"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="cs38AECAED" colspan="11"
                    style="width:279px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">
                    <nobr>**Merci&nbsp;pour&nbsp;la&nbsp;visite&nbsp;**</nobr>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>


    
              </div>
    
              <!-- fin -->
            </v-card-text>
    
            <!-- container -->

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
              <v-btn color="primary" dark :loading="loading" @click="printBill">
                {{ "Imprimer" }}
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    
    
    
    
    </template>
    <script>
    import { mapGetters, mapActions } from "vuex";
    export default {
      data() {
        return {
    //
          title: "Liste des Details",
          dialog: false,
          edit: false,
          loading: false,
          disabled: false,
          dialog2: false,

          titleComponent: '',
          refEnteteSortie: 0,
          ServiceData:'',

          isLoadingData: false,
          bobo: "corneille",
          test: {},
          entete: {},
          donneesvente: {},
          svData: {
            id : 0,
            nombre_print :0,
          },
          don: [],
          query: "",
          
          inserer:'',
          modifier:'',
          supprimer:'',
          chargement:''
    
        }
      },
      created() {
        // this.showModel(this.refEnteteSortie);
      },
      computed: {
        ...mapGetters(["categoryList", "isloading"]),
      },
      methods: {
    
        ...mapActions(["getCategory"]), 
  
    showModel(id) {

      let donnees = {}
      let _donneesvente = {}



      this.editOrFetch(`${this.apiBaseURL}/fetch_entreprise_2`).then(
        // this.isLoadingData = true,
        ({ data }) => {
          if (data) {
            donnees = data.data
          }

          donnees.map((item) => {
            //console.log('Teste Item:',item);
            this.test = item
            this.logo = item.logo
          })
          //console.log('Teste dataEsp:',this.test);
          // this.isLoadingData = false
        }
      );

      this.isLoading(false);

      if (this.ServiceData == 'Ventes')
      {
          this.editOrFetch(`${this.apiBaseURL}/fetch_detail_facture_chambre/${id}`).then(
          ({ data }) => {
            if (data) {
              _donneesvente = data.data
              this.donneesvente = _donneesvente
            }
            console.log('Teste v-for:', _donneesvente);
            _donneesvente.map((item) => {
              //console.log('Teste Item:',item);
              this.entete = item
            })

          }
        );
      }

      

    },
    async printBill() {       
        await this.$htmlToPaper('printMe');

    //    this.svData.id = this.refEnteteSortie;
    //    this.svData.nombre_print ++;

    //       this.insertOrUpdate(
    //         `${this.apiBaseURL}/update_nombre_print/${this.svData.id}`,
    //         JSON.stringify(this.svData)
    //       )
    //         .then(({ data }) => {
    //           //this.showMsg(data.data);
    //           this.isLoading(false);
    //           this.resetObj(this.svData);
    //           this.$htmlToPaper('printMe');
    //         })
    //         .catch((err) => {
    //           this.svErr(), this.isLoading(false);
    //         });
    }      
    
    
      },
      filters: {
    
      }
    }
    </script>
    <style>
    .cs5971619E {
      color: #000000;
      background-color: #000000;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 13px;
      font-weight: normal;
      font-style: normal;
    }
    
    .csEF71EB8E {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Microsoft Sans Serif;
      font-size: 14px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
    }
    
    .csA2F7C04E {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Microsoft Sans Serif;
      font-size: 14px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
      padding-right: 2px;
    }
    
    .csAA7EBA13 {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Microsoft Sans Serif;
      font-size: 14px;
      font-weight: normal;
      font-style: normal;
      padding-left: 2px;
    }
    
    .cs3A663619 {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Microsoft Sans Serif;
      font-size: 26px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
    }
    
    .csA803F7DA {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 12px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
      padding-right: 2px;
    }
    
    .cs8A513397 {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 13px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
    }
    
    .cs8BD51C12 {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 13px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
      padding-right: 2px;
    }
    
    .cs101A94F7 {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 13px;
      font-weight: normal;
      font-style: normal;
    }
    
    .csCE72709D {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 14px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
    }
    
    .cs38AECAED {
      color: #000000;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Times New Roman;
      font-size: 14px;
      font-weight: bold;
      font-style: normal;
      padding-left: 2px;
      padding-right: 2px;
    }
    
    .cs739196BC {
      color: #5c5c5c;
      background-color: transparent;
      border-left-style: none;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      font-family: Segoe UI;
      font-size: 11px;
      font-weight: normal;
      font-style: normal;
    }
    
    .csF7D3565D {
      height: 0px;
      width: 0px;
      overflow: hidden;
      font-size: 0px;
      line-height: 0px;
    }
    </style>
    