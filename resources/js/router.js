import Vue from 'vue'
import VueRouter from 'vue-router'
import VueRouteMiddleware from 'vue-route-middleware';
import isNotAdmin from './app/middleware/isNotAdmin'
import isNotUser from './app/middleware/isNotUser'
import isNotMember from './app/middleware/isAdminOrSubAdmin'




Vue.use(VueRouter);

import Info from './views/info.vue'
import Dashboard from './views/Dashboard'



import Profil_stat from './views/Dashboard'

import Role from './views/backend/admin/role.vue'
import Users from './views/backend/admin/crud.vue'
import Site from './views/backend/admin/configure_site.vue'
import Basic from './views/backend/admin/configure_basic.vue'

import Service from './views/backend/admin/services.vue'
import Operation_blog from './views/backend/admin/operation_blog.vue'
import Operation_partenaire from './views/backend/admin/operation_partenaire.vue'
import Operation_galery from './views/backend/admin/operation_galery.vue'
import Operation_video from './views/backend/admin/operation_video.vue'
import UserProfil from './views/backend/admin/userProfil.vue'
import UserSecure from './views/backend/admin/basicSecure.vue'

import profil_stat from  './views/backend/admin/pnud/profil_stat.vue'


/*
*les scripts commencent
*=====================
*pnud management project
*------------------------
*/

import Pays from './views/backend/admin/pnud/pays.vue'
import Province from './views/backend/admin/pnud/province.vue'
import Secteur from './views/backend/admin/pnud/secteur.vue'
import forme_juridique from './views/backend/admin/pnud/formeJuridique.vue'
import Liste_entreprise from './views/backend/admin/pnud/liste_entreprise.vue'
import entrepriseDetail from './views/backend/admin/pnud/entrepriseDetail.vue'
import CanvasEntrepriseDetail from './views/backend/admin/pnud/canvasEntrepriseDetail.vue'
import SwotEntrepriseDetailProjet from './views/backend/admin/pnud/SwotEntrepriseDetailProjet.vue'
import Entreprise from './views/backend/admin/pnud/pages/entreprises.vue'
import Statistique_entreprise  from './views/backend/admin/pnud/statistique_entreprise.vue'
import Statistique_user  from './views/backend/admin/pnud/pages/statistiqueUtilisateur.vue'
import DashboardAdmin from  './views/backend/admin/pnud/pages/dashbord.vue'
// import DashboardAdmin from  './views/backend/admin/pnud/pages/Admindashboard.vue'
import weekAdmin from  './views/backend/admin/pnud/pages/week.vue'


//burega
import operation_catArticle from './views/backend/admin/categoryArticle.vue'
import operation_territoire from './views/backend/admin/Territoire.vue'
import Team from './views/backend/admin/configure_team.vue'
import Contact_info from './views/backend/admin/configure_contact_info.vue'
import Carousel from './views/backend/admin/configure_carousel.vue'
import Texto from './views/backend/admin/Texto.vue'
//fin burega


import Temoignages from './views/backend/admin/configure_temoignage.vue'
import Valeur from './views/backend/admin/configure_valeur.vue'

import Choix from './views/backend/admin/configure_choix.vue'
import Decision from './views/backend/admin/configure_decision.vue'
import Avantage from './views/backend/admin/configure_avantage.vue'
import NosServices from './views/backend/admin/configure_valeur_services.vue'

import role_service from './views/backend/admin/configure_role.vue'
import Sous_services from './views/backend/admin/configure_sous_service.vue'
import ProfilPatient from './views/backend/Patients/ProfilPatient.vue' 
import ProfilPatient_Client from './views/backend/Patients/ProfilPatient_Client.vue' 



import ClassesFin from './views/backend/Finances/Classes.vue'
import CompteFin from './views/backend/Finances/CompteFin.vue'
import SousCompte from './views/backend/Finances/SousCompte.vue'
import SSousCompte from './views/backend/Finances/SSousCompte.vue'
import TypeCompte from './views/backend/Finances/TypeCompte.vue'
import TypeOperation from './views/backend/Finances/TypeOperation.vue'
import TypePosition from './views/backend/Finances/TypePosition.vue'
import TTaux from './views/backend/Finances/TTaux.vue'
import Banque from './views/backend/Finances/Banque.vue'
import modepaie from './views/backend/Finances/ModePaiement.vue'

import Cloture_Caisse from './views/backend/Finances/Cloture_Caisse.vue'
import Cloture_Caisse_Salle from './views/backend/Finances/Cloture_Caisse_Salle.vue'
import Cloture_Caisse_Chambre from './views/backend/Finances/Cloture_Caisse_Chambre.vue'
import Cloture_Caisse_Billard from './views/backend/Finances/Cloture_Caisse_Billard.vue'
import ClotureComptabilite from './views/backend/Finances/ClotureComptabilite.vue'
//DepenseAll

import depense from './views/backend/Finances/Depenses.vue'
import DepenseAll from './views/backend/Finances/DepenseAll.vue'
import recette from './views/backend/Finances/Ressources.vue'
import Comptes from './views/backend/Finances/Comptes.vue'
import EnteteOperationComptable from './views/backend/Finances/EnteteOperationComptable.vue'

import Blocs from './views/backend/Tresorerie/Blocs.vue'
import CategorieRubrique from './views/backend/Tresorerie/CategorieRubrique.vue'
import EnteteEtatBesoin from './views/backend/Tresorerie/EnteteEtatBesoin.vue'
import Provenance from './views/backend/Tresorerie/Provenance.vue'
import Rubriques from './views/backend/Tresorerie/Rubriques.vue'
import EnteteBonEngagement from './views/backend/Tresorerie/EnteteBonEngagement.vue'

import RapportsJour_Caisse from './views/backend/Rapports/Finances/RapportsJour_Caisse.vue'
import RapportsComptabilite from './views/backend/Rapports/Finances/RapportsComptabilite.vue'
import RapportsJour_Logistique from './views/backend/Rapports/Finances/RapportsJour_Logistique.vue'


import CategorieProduit from './views/backend/Ventes/CategorieProduit.vue'
import Produits from './views/backend/Ventes/Produits.vue'
import Fournisseur from './views/backend/Ventes/Fournisseur.vue'
import ParamSystem from './views/backend/Ventes/ParamSystem.vue'
import RetourStock from './views/backend/Ventes/RetourStock.vue'
//RetourStock

import LogEnteteEntree from './views/backend/Logistique/LogEnteteEntree.vue'
import LogEnteteRequisition from './views/backend/Logistique/LogEnteteRequisition.vue'
import LogEnteteSortie from './views/backend/Logistique/LogEnteteSortie.vue'
import ServiceLog from './views/backend/Logistique/Services.vue'
import Emplacements from './views/backend/Logistique/Emplacements.vue'
//TypeStage

import CategorieAgent from './views/backend/Personnels/CategorieAgent.vue'
import FonctionAgent from './views/backend/Personnels/FonctionAgent.vue'
import Agent from './views/backend/Personnels/Agent.vue'
import TypeAgent from './views/backend/Personnels/TypeAgent.vue'
import CategorieRubriquePers from './views/backend/Personnels/CategorieRubriquePers.vue'
import Postes from './views/backend/Personnels/Postes.vue'
import Mutuelle from './views/backend/Personnels/Mutuelle.vue'
import LieuAffectation from './views/backend/Personnels/LieuAffectation.vue'
import TypeCirconstance from './views/backend/Personnels/TypeCirconstance.vue'
import TypeContrat from './views/backend/Personnels/TypeContrat.vue'
import TypeStage from './views/backend/Personnels/TypeStage.vue'
import CategorieServicePers from './views/backend/Personnels/CategorieServicePers.vue'
import ServicePersonnel from './views/backend/Personnels/ServicePersonnel.vue'
import CategorieCirconstance from './views/backend/Personnels/CategorieCirconstance.vue'
//CategorieCirconstance
import ParametreSalairebBase from './views/backend/Personnels/ParametreSalairebBase.vue'
import Annee from './views/backend/Personnels/Annee.vue'
import Mois from './views/backend/Personnels/Mois.vue'
import RaisonFamilliale from './views/backend/Personnels/RaisonFamilliale.vue'
import RubriquePaie from './views/backend/Personnels/RubriquePaie.vue'
import ParametreRubrique from './views/backend/Personnels/ParametreRubrique.vue'
import FichePaie from './views/backend/Personnels/FichePaie.vue'
import FichePaieGlobale from './views/backend/Personnels/FichePaieGlobale.vue'
import RapportsJour_Personnel from './views/backend/Rapports/Finances/RapportsJour_Personnel.vue'
import RapportContrat from './views/backend/Rapports/Finances/RapportContrat.vue'
import RapportsJour_Vente from './views/backend/Rapports/Finances/RapportsJour_Vente.vue'
import RapportsJour_Reservation from './views/backend/Rapports/Finances/RapportsJour_Reservation.vue'

import DivisionArchive from './views/backend/Personnels/DivisionArchive.vue'
import CategorieArchivage from './views/backend/Personnels/CategorieArchivage.vue'
import ServiceArchivage from './views/backend/Personnels/ServiceArchivage.vue'
import Promotion from './views/backend/Personnels/Promotion.vue'
import OptionStage from './views/backend/Personnels/OptionStage.vue'
import DomaineStage from './views/backend/Personnels/DomaineStage.vue'
import AnneeStage from './views/backend/Personnels/AnneeStage.vue'
import Institution from './views/backend/Personnels/Institution.vue'
import Archivages from './views/backend/Personnels/Archivages.vue'
import JourPresences from './views/backend/Personnels/JourPresences.vue'
import Projets from './views/backend/Personnels/Projets.vue'
import PartenaireProjet from './views/backend/Personnels/PartenaireProjet.vue'
import Backups from './views/backend/Personnels/Backups.vue'

import AllContrat from './views/backend/Personnels/AllContrat.vue'
import ContratsEncours from './views/backend/Personnels/ContratsEncours.vue'
import ContratFini from './views/backend/Personnels/ContratFini.vue'
import ContratEnconge from './views/backend/Personnels/ContratEnconge.vue'
import ContratActif from './views/backend/Personnels/ContratActif.vue'
import AllPresenceAgent from './views/backend/Personnels/AllPresenceAgent.vue'
import ImportPresence from './views/backend/Personnels/ImportPresence.vue'
//ImportPresence

import AllCorrespondance from './views/backend/Personnels/AllCorrespondance.vue'
import AllTimeSheet from './views/backend/Personnels/AllTimeSheet.vue'
import JourCorrespondance from './views/backend/Personnels/JourCorrespondance.vue'
import JourTimeSheet from './views/backend/Personnels/JourTimeSheet.vue'
import UserCorrespondance from './views/backend/Personnels/UserCorrespondance.vue'
import UserTimeSheet from './views/backend/Personnels/UserTimeSheet.vue'

import AllStages from './views/backend/Personnels/AllStages.vue'
import StageEncours from './views/backend/Personnels/StageEncours.vue'

import SalonEnteteVente from './views/backend/Salon/SalonEnteteVente.vue'

import ProduitLog from './views/backend/Logistique/ProduitLog.vue'



import ClientVente from './views/backend/Ventes/ClientVente.vue'
import VenteEnteteCommande from './views/backend/Ventes/VenteEnteteCommande.vue'
import VenteEnteteEntree from './views/backend/Ventes/VenteEnteteEntree.vue'
import VenteEnteteVente from './views/backend/Ventes/VenteEnteteVente.vue'
import CategorieClient from './views/backend/Ventes/CategorieClient.vue'
import TestExcel from './views/backend/Ventes/TestExcel.vue'
import VenteGrandeCategorieProduit from './views/backend/Ventes/VenteGrandeCategorieProduit.vue'
import CreateRestoreProduct from './views/backend/Ventes/CreateRestoreProduct.vue'
import ApprovCommandes from './views/backend/Ventes/ApprovCommandes.vue'
import CreateAjustement from './views/backend/Ventes/CreateAjustement.vue'
import TranfertUsage from './views/backend/Ventes/TranfertUsage.vue'

import RapportEntree from './views/backend/Ventes/RapportEntree.vue'
import RapportSortie from './views/backend/Ventes/RapportSortie.vue'

import VenteEnteteFactureGroupe from './views/backend/Ventes/VenteEnteteFactureGroupe.vue'
import CreateFactureGroupe from './views/backend/Ventes/CreateFactureGroupe.vue'
//RaportVenteAcces
import CategorieFournisseur from './views/backend/Ventes/CategorieFournisseur.vue'
import VenteAutorisation from './views/backend/Ventes/VenteAutorisation.vue'
import VenteModules from './views/backend/Ventes/VenteModules.vue'
import RaportVenteAcces from './views/backend/Ventes/RaportVenteAcces.vue'
import VenteEnteteDette from './views/backend/Ventes/VenteEnteteDette.vue'
import CreateVenteGros from './views/backend/Ventes/CreateVenteGros.vue'
import VenteServices from './views/backend/Ventes/VenteServices.vue'
import VenteUnite from './views/backend/Ventes/VenteUnite.vue'
import Commandes from './views/backend/Ventes/Commandes.vue'
import Approvisionnements from './views/backend/Ventes/Approvisionnements.vue'
import VenteEntetePaieCmd from './views/backend/Ventes/VenteEntetePaieCmd.vue'
import VenteEnteteTransfert from './views/backend/Ventes/VenteEnteteTransfert.vue'
import VenteServicesData from './views/backend/Ventes/VenteServicesData.vue'
import TransfertStock from './views/backend/Ventes/TransfertStock.vue'
import VenteTVA from './views/backend/Ventes/VenteTVA.vue'
import VenteUserService from './views/backend/Ventes/VenteUserService.vue'
import VenteDevise from './views/backend/Ventes/VenteDevise.vue'
import StatistiqueVente from './views/backend/Ventes/StatistiqueVente.vue'
// StatistiqueVente
import CreateVentes from './views/backend/Ventes/CreateVentes.vue'
import VenteEntetePaieVente from './views/backend/Ventes/VenteEntetePaieVente.vue'
import VenteTables from './views/backend/Ventes/VenteTables.vue'
import CreateInventaire from './views/backend/Ventes/CreateInventaire.vue'
import VenteEnteteInventaire from './views/backend/Ventes/VenteEnteteInventaire.vue'
import VenteEnteteCuisine from './views/backend/Ventes/VenteEnteteCuisine.vue'
import CreateCommandeCuisine from './views/backend/Ventes/CreateCommandeCuisine.vue'

import GazCreateVente from './views/backend/Gaz/GazCreateVente.vue' 
import GazEnteteVente from './views/backend/Gaz/GazEnteteVente.vue'
import GazEntetepaiementVente from './views/backend/Gaz/GazEntetepaiementVente.vue'
import GazCreateProduction from './views/backend/Gaz/GazCreateProduction.vue'
import GazEnteteProduction from './views/backend/Gaz/GazEnteteProduction.vue'
import GazTransfertStock from './views/backend/Gaz/GazTransfertStock.vue'
import GazEnteteTransfert from './views/backend/Gaz/GazEnteteTransfert.vue'
import GazCreateRestoreKit from './views/backend/Gaz/GazCreateRestoreKit.vue'

// GazCreateRestoreKit

import GazCreateUsage from './views/backend/Gaz/GazCreateUsage.vue'
import GazCreateInventaire from './views/backend/Gaz/GazCreateInventaire.vue'
import GazEnteteInventaire from './views/backend/Gaz/GazEnteteInventaire.vue'
import GazEnteteUsage from './views/backend/Gaz/GazEnteteUsage.vue'

import Lot from './views/backend/Gaz/Lot.vue'
import RapportGaz from './views/backend/Gaz/RapportGaz.vue'
// RapportGaz
import GazCategorieLot from './views/backend/Gaz/GazCategorieLot.vue'

import VenteEnteteUse from './views/backend/Ventes/VenteEnteteUse.vue'
import CreateUsage from './views/backend/Ventes/CreateUsage.vue'


import CarEnteteMouvement from './views/backend/Vehicule/CarEnteteMouvement.vue'
import CarProduit from './views/backend/Vehicule/CarProduit.vue'
import CarVehicule from './views/backend/Vehicule/CarVehicule.vue'
import CarProducteur from './views/backend/Vehicule/CarProducteur.vue'

import Chambre from './views/backend/Hotel/Chambre.vue'
import ClasseChambre from './views/backend/Hotel/ClasseChambre.vue'
import ClientHotel from './views/backend/Hotel/ClientHotel.vue'
import ReservationAll from './views/backend/Hotel/ReservationAll.vue'
import LocationAppartementAll from './views/backend/Hotel/LocationAppartementAll.vue'
import Salle from './views/backend/Hotel/Salle.vue'

//LocationAppartementAll

import SalonProduit from './views/backend/Salon/SalonProduit.vue'
import RapportsJour_VenteSalon from './views/backend/Rapports/Finances/RapportsJour_VenteSalon.vue'
import RapportsJour_Vehicule from './views/backend/Rapports/Finances/RapportsJour_Vehicule.vue'
import RapportTimeSheet from './views/backend/Rapports/Finances/RapportTimeSheet.vue'

import ListeMenu from './views/backend/Parametres/ListeMenu.vue'
import HistoriqueData from './views/backend/Parametres/HistoriqueData.vue'
//Approvisionnements

/*
*les scripts commencent users
*=====================
*pnud management user
*------------------------
*/
import Liste_entreprise_user from './views/backend/admin/pnud/liste_entreprise_user.vue'
import GroupChat from  './views/backend/admin/pnud/pages/groupChat.vue'

/*
*les scripts commencent users
*=====================
*pnud management user
*------------------------
*/

import Ville from './views/backend/projet/Ville.vue'
import Commune from './views/backend/projet/Commune.vue'
import Quartier from './views/backend/projet/Quartier.vue'
import Avenue from './views/backend/projet/Avenue.vue'


/*
*les scripts commencent
*=====================
*pnud management project
*------------------------
*/



const Router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/apps/infos',
      name: 'infos',
      component: Info,

    },
    {
      path: '/dashbord',
      name: 'dashboard_1',
      component: DashboardAdmin,
      // meta: { middleware: [isNotAdmin] }
    },


    /*
    *script pouir site web
    *=======================
    *======================== 
    * 
  
    */
    {
      path: '/admin/temoignages',
      name: 'temoignages_one',
      component: Temoignages,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/valeur',
      name: 'valeur_one',
      component: Valeur,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/choix',
      name: 'choix_one',
      component: Choix,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/decision',
      name: 'decision_one',
      component: Decision,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/avantage',
      name: 'avantage_one',
      component: Avantage,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/service',
      name: 'service_one',
      component: NosServices,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/role_service',
      name: 'role_service_one',
      component: role_service,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/sous_service',
      name: 'sous_service_one',
      component: Sous_services,
      meta: { middleware: [isNotAdmin] }
    },

     /*
    *script pouir site web
    *=======================
    *======================== 
    * 
  
    */



   
    {
      path: '/admin/profil',
      name: 'profil_1',
      component: UserProfil,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/role',
      name: 'role',
      component: Role,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/Users',
      name: 'Users',
      component: Users
      // meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/configure_site',
      name: 'configure_site',
      component: Site,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/configure_basic',
      name: 'configure_basic',
      component: Basic,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/operation_service',
      name: 'operation_service',
      component: Service,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/operation_blog',
      name: 'operation_blog',
      component: Operation_blog,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/operation_partenaire',
      name: 'operation_partenaire',
      component: Operation_partenaire,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/operation_galery',
      name: 'operation_galery',
      component: Operation_galery,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/operation_video',
      name: 'operation_video',
      component: Operation_video,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/security',
      name: 'security',
      component: UserSecure,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/chat',
      name: 'chat_1',
      component: GroupChat,
      meta: { middleware: [isNotAdmin] }
    },


    

    


    /*
    *scripts pour pnud
    *==================
    */

    {
      path: '/admin/pays',
      name: 'pays',
      component: Pays,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/provinces',
      name: 'province',
      component: Province,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/secteur',
      name: 'secteur',
      component: Secteur,
      meta: { middleware: [isNotAdmin] }
    },

   
    
    {
      path: '/admin/forme_juridique',
      name: 'forme_juridique',
      component: forme_juridique,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/liste_entreprise',
      name: 'liste_entreprise',
      component: Liste_entreprise
      // ,
      // meta: { middleware: [isNotAdmin] }
    },
    
    {
      path: "/admin/entreprise_detail/:slug",
      name: "entreprise_detail_1",
      component: entrepriseDetail,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: "/admin/canvas_entreprise_detail/:slug",
      name: "canvas_entreprise_detail_1",
      component: CanvasEntrepriseDetail,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: "/admin/swot_entreprise_detail/:slug",
      name: "swot_entreprise_detail_1",
      component: SwotEntrepriseDetailProjet,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/entreprises',
      name: 'entreprises',
      component: Entreprise,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/statistique_entreprise',
      name: 'statistique_entreprise',
      component: Statistique_entreprise,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/statistique_user',
      name: 'statistique_user',
      component: Statistique_user,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/dashboard',
      name: 'dashboard_admin',
      component: DashboardAdmin,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/week',
      name: 'week_admin',
      component: weekAdmin,
      meta: { middleware: [isNotAdmin] }
    },

    //burega
    {
      path: '/admin/operation_catArticle',
      name: 'operation_catArticle',
      component: operation_catArticle,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/territoire',
      name: 'territoire',
      component: operation_territoire,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/operation_team',
      name: 'operation_team',
      component: Team,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/contact_info',
      name: 'contact_info_one',
      component: Contact_info,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/carousel',
      name: 'carousel_one',
      component: Carousel,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/texto',
      name: 'texto_one',
      component: Texto,
      meta: { middleware: [isNotAdmin] }
    },

    //hopital
    {
      path: '/admin/ville',
      name: 'ville',
      component: Ville,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/commune',
      name: 'commune',
      component: Commune,
      meta: { middleware: [isNotAdmin] }
    },
    {
      path: '/admin/quartier',
      name: 'quartier',
      component: Quartier,
      meta: { middleware: [isNotAdmin] }
    },

    {
      path: '/admin/avenue',
      name: 'avenue',
      component: Avenue,
      meta: { middleware: [isNotAdmin] }
    },
    

   
    
    

    
    
    

    
    

    

    /*
    *scripts pour pnud
    *==================
    */


    

   


    
    

    

    


    /*
    *
    *===============
    * *
    * *
    * *
    * *
    * fin lien de users
    * liens de users
    * =================

    */

    
    {
      path: '/user/dashboard',
      name: 'dashbord2',
      component: DashboardAdmin,
      meta: { middleware: [isNotUser] }
    },
    {
      path: '/user/profil',
      nema: 'profil2',
      component: UserProfil,
      // meta: { middleware: [isNotUser] }
    },

    {
      path: '/user/security',
      name: 'security2',
      component: UserSecure,
      meta: { middleware: [isNotUser] }
    },

    {
      path: '/user/liste_entreprise',
      name: 'liste_entreprise_2',
      component: Liste_entreprise_user,
      meta: { middleware: [isNotUser] }
    },

    {
      path: "/user/entreprise_detail/:slug",
      name: "entreprise_detail_2",
      component: entrepriseDetail,
      meta: { middleware: [isNotUser] }
    },

    {
      path: "/user/canvas_entreprise_detail/:slug",
      name: "canvas_entreprise_detail_2",
      component: CanvasEntrepriseDetail,
      meta: { middleware: [isNotUser] }
    },
    {
      path: "/user/swot_entreprise_detail/:slug",
      name: "swot_entreprise_detail_2",
      component: SwotEntrepriseDetailProjet,
      meta: { middleware: [isNotUser] }
    },
    {
      path: "/user/profil_stat",
      name: "profil_stat_2",
      component: profil_stat,
      meta: { middleware: [isNotUser] }
    },

    {
      path: '/user/chat',
      name: 'chat_2',
      component: GroupChat,
      meta: { middleware: [isNotUser] }
    },
    

     /*
    *
    *===============
    * *
    * *
    * *
    * *
    * fin lien de users
    * liens de users
    * =================

    */

    
    {
      path: '/member/dashboard',
      name: 'dashbord_3',
      component: DashboardAdmin,
      // meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/profil',
      nema: 'profil_3',
      component: UserProfil,
      // meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/security',
      name: 'security_3',
      component: UserSecure,
      meta: { middleware: [isNotMember] }
    },



     /*
    *script pouir site web
    *=======================
    *======================== 
    * 
  
    */    
    {
      path: '/member/temoignages',
      name: 'temoignages_thre',
      component: Temoignages,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/valeur',
      name: 'valeur_thre',
      component: Valeur,
      meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/choix',
      name: 'choix_thre',
      component: Choix,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/decision',
      name: 'decision_thre',
      component: Decision,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/avantage',
      name: 'avantage_thre',
      component: Avantage,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/service',
      name: 'service_thre',
      component: NosServices,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/role_service',
      name: 'role_service_thre',
      component: role_service,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/sous_service',
      name: 'sous_service_thre',
      component: Sous_services,
      meta: { middleware: [isNotMember] }
    },

    // autres
    {
      path: '/member/week',
      name: 'week_admin_thre',
      component: weekAdmin,
      meta: { middleware: [isNotMember] }
    },

    //burega
    {
      path: '/member/operation_catArticle',
      name: 'operation_catArticle_thre',
      component: operation_catArticle,
      meta: { middleware: [isNotMember] }
    },

    
    {
      path: '/member/operation_team',
      name: 'operation_team_thre',
      component: Team,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/contact_info',
      name: 'contact_info_thre',
      component: Contact_info,
      meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/carousel',
      name: 'carousel_thre',
      component: Carousel,
      meta: { middleware: [isNotMember] }
    },

     /*
    *script pouir site web
    *=======================
    *======================== 
    * 
  
    */

    {
      path: '/member/operation_blog',
      name: 'operation_blog_2',
      component: Operation_blog,
      meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/operation_partenaire',
      name: 'operation_partenaire_2',
      component: Operation_partenaire,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/operation_galery',
      name: 'operation_galery_2',
      component: Operation_galery,
      meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/operation_video',
      name: 'operation_video_2',
      component: Operation_video,
      meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/chat',
      name: 'chat_3',
      component: GroupChat,
      meta: { middleware: [isNotMember] }
    },
    {
      path: '/admin/ProfilPatient',
      name: 'ProfilPatient',
      component: ProfilPatient
      // ,
      // meta: { middleware: [isNotMember] }
    },
    {
      path: '/member/ProfilPatient_Client',
      name: 'ProfilPatient_Client',
      component: ProfilPatient_Client
      // ,
      // meta: { middleware: [isNotMember] }
    },

    {
      path: '/member/operation_service',
      name: 'operation_service_thre',
      component: Service,
      meta: { middleware: [isNotMember] }
    },
    {
        path: '/admin/Comptes',
        name: 'Comptes',
        component: Comptes,
        //meta: { middleware: [isNotAdmin] }
    },
    {
        path: '/admin/depense',
        name: 'depense',
        component: depense,
        //meta: { middleware: [isNotAdmin] }
    },
    {
        path: '/admin/recette',
        name: 'recette',
        component: recette,
        //meta: { middleware: [isNotAdmin] }
    },
    {
        path: '/admin/ClassesFin',
        name: 'ClassesFin',
        component: ClassesFin,
    },
    {
        path: '/admin/CompteFin',
        name: 'CompteFin',
        component: CompteFin,
    },
    {
        path: '/admin/SousCompte',
        name: 'SousCompte',
        component: SousCompte,
    },
    {
        path: '/admin/SSousCompte',
        name: 'SSousCompte',
        component: SSousCompte,
    },
    {
        path: '/admin/TypeCompte',
        name: 'TypeCompte',
        component: TypeCompte,
    },
    {
        path: '/admin/TypeOperation',
        name: 'TypeOperation',
        component: TypeOperation,
    },
    {
        path: '/admin/TypePosition',
        name: 'TypePosition',
        component: TypePosition,
    },
    {
        path: '/admin/Banque',
        name: 'Banque',
        component: Banque,
    },
    {
        path: '/admin/DivisionArchive',
        name: 'DivisionArchive',
        component: DivisionArchive,
    },
    {
        path: '/admin/CategorieArchivage',
        name: 'CategorieArchivage',
        component: CategorieArchivage,
    },
    {
        path: '/admin/ServiceArchivage',
        name: 'ServiceArchivage',
        component: ServiceArchivage,
    },
    {
        path: '/admin/PartenaireProjet',
        name: 'PartenaireProjet',
        component: PartenaireProjet,
    },
    {
        path: '/admin/Projets',
        name: 'Projets',
        component: Projets,
    },
    {
        path: '/admin/Archivages',
        name: 'Archivages',
        component: Archivages,
    },
    {
        path: '/admin/Promotion',
        name: 'Promotion',
        component: Promotion,
    },
    {
        path: '/admin/OptionStage',
        name: 'OptionStage',
        component: OptionStage,
    },
    {
        path: '/admin/DomaineStage',
        name: 'DomaineStage',
        component: DomaineStage,
    },
    {
        path: '/admin/AnneeStage',
        name: 'AnneeStage',
        component: AnneeStage,
    },
    { 
        path: '/admin/Institution',
        name: 'Institution',
        component: Institution,
    },
    { 
        path: '/admin/VenteEntetePaieCmd',
        name: 'VenteEntetePaieCmd',
        component: VenteEntetePaieCmd,
    },
    { //VenteServicesData
        path: '/admin/VenteEnteteTransfert',
        name: 'VenteEnteteTransfert',
        component: VenteEnteteTransfert,
    },
    { //VenteServicesData
        path: '/admin/VenteServicesData',
        name: 'VenteServicesData',
        component: VenteServicesData,
    },
    { 
        path: '/admin/VenteDevise',
        name: 'VenteDevise',
        component: VenteDevise,
    },
    { 
        path: '/admin/StatistiqueVente',
        name: 'StatistiqueVente',
        component: StatistiqueVente,
    },
    { //StatistiqueVente
        path: '/admin/CreateVentes',
        name: 'CreateVentes',
        component: CreateVentes,
    },
    { //
        path: '/admin/VenteEntetePaieVente',
        name: 'VenteEntetePaieVente',
        component: VenteEntetePaieVente,
    },
    { //
        path: '/admin/VenteTables',
        name: 'VenteTables',
        component: VenteTables,
    },
    { 
        path: '/admin/VenteUserService',
        name: 'VenteUserService',
        component: VenteUserService,
    },
    {        
        path: '/admin/VenteEnteteUse',
        name: 'VenteEnteteUse',
        component: VenteEnteteUse,
    },
    { 
        path: '/admin/CreateUsage',
        name: 'CreateUsage',
        component: CreateUsage,
    },
    { 
        path: '/admin/VenteTVA',
        name: 'VenteTVA',
        component: VenteTVA,
    },
    { 
        path: '/admin/VenteEnteteCuisine',
        name: 'VenteEnteteCuisine',
        component: VenteEnteteCuisine,
    },
    {  
        path: '/admin/CreateCommandeCuisine',
        name: 'CreateCommandeCuisine',
        component: CreateCommandeCuisine,
    },
    { 
        path: '/admin/CreateInventaire',
        name: 'CreateInventaire',
        component: CreateInventaire,
    },
    { 
        path: '/admin/VenteEnteteInventaire',
        name: 'VenteEnteteInventaire',
        component: VenteEnteteInventaire,
    },
    { 
        path: '/admin/TransfertStock',
        name: 'TransfertStock',
        component: TransfertStock,
    },
    { //VenteEnteteTransfert
        path: '/admin/Commandes',
        name: 'Commandes',
        component: Commandes,
    },
    { //Approvisionnements
        path: '/admin/Approvisionnements',
        name: 'Approvisionnements',
        component: Approvisionnements,
    },
    {
        path: '/admin/Cloture_Caisse',
        name: 'Cloture_Caisse',
        component: Cloture_Caisse,
    },
    {
        path: '/admin/Cloture_Caisse_Billard',
        name: 'Cloture_Caisse_Billard',
        component: Cloture_Caisse_Billard,
    },
    {
        path: '/admin/Cloture_Caisse_Chambre',
        name: 'Cloture_Caisse_Chambre',
        component: Cloture_Caisse_Chambre,
    },
    {
        path: '/admin/Cloture_Caisse_Salle',
        name: 'Cloture_Caisse_Salle',
        component: Cloture_Caisse_Salle,
    },
    {
        path: '/admin/modepaie',
        name: 'modepaie',
        component: modepaie,
    },
    {
        path: '/admin/TTaux',
        name: 'TTaux',
        component: TTaux,
    },
    {
        path: '/admin/CategorieRubrique',
        name: 'CategorieRubrique',
        component: CategorieRubrique,
    },
    {//
        path: '/admin/Provenance',
        name: 'Provenance',
        component: Provenance,
    },
    {
        path: '/admin/Rubriques',
        name: 'Rubriques',
        component: Rubriques,
    },
    {
        path: '/admin/EnteteBonEngagement',
        name: 'EnteteBonEngagement',
        component: EnteteBonEngagement,
    },
    {
        path: '/admin/Blocs',
        name: 'Blocs',
        component: Blocs,
    },
    {
        path: '/admin/EnteteEtatBesoin',
        name: 'EnteteEtatBesoin',
        component: EnteteEtatBesoin,
    },
    {
        path: '/admin/RapportsJour_Caisse',
        name: 'RapportsJour_Caisse',
        component: RapportsJour_Caisse,
    },
    {
        path: '/admin/RapportsComptabilite',
        name: 'RapportsComptabilite',
        component: RapportsComptabilite,
    },
    {
        path: '/admin/EnteteOperationComptable',
        name: 'EnteteOperationComptable',
        component: EnteteOperationComptable,
    },
    {
      path: '/admin/RapportsJour_Logistique',
        name: 'RapportsJour_Logistique',
        component: RapportsJour_Logistique     
    },
    {
        path: '/admin/LogEnteteEntree',
        name: 'LogEnteteEntree',
        component: LogEnteteEntree,
    },
    {
        path: '/admin/LogEnteteRequisition',
        name: 'LogEnteteRequisition',
        component: LogEnteteRequisition,
    },
    {
        path: '/admin/LogEnteteSortie',
        name: 'LogEnteteSortie',
        component: LogEnteteSortie,
    },
    {
        path: '/admin/CategorieProduit',
        name: 'CategorieProduit',
        component: CategorieProduit,
    },
    {
        path: '/admin/Produits',
        name: 'Produits',
        component: Produits,
    },
    { //RetourStock
        path: '/admin/Fournisseur',
        name: 'Fournisseur',
        component: Fournisseur,
    },
    { //RetourStock
        path: '/admin/RetourStock',
        name: 'RetourStock',
        component: RetourStock,
    },
    {
        path: '/admin/ParamSystem',
        name: 'ParamSystem',
        component: ParamSystem,
    },
    { 
        path: '/admin/CategorieFournisseur',
        name: 'CategorieFournisseur',
        component: CategorieFournisseur,
    },
    {
        path: '/admin/VenteAutorisation',
        name: 'VenteAutorisation',
        component: VenteAutorisation,
    },
    { 
        path: '/admin/VenteModules',
        name: 'VenteModules',
        component: VenteModules,
    },
    { //
        path: '/admin/RaportVenteAcces',
        name: 'RaportVenteAcces',
        component: RaportVenteAcces,
    },
    { //CreateVenteGros
        path: '/admin/VenteEnteteDette',
        name: 'VenteEnteteDette',
        component: VenteEnteteDette,
    },
    { //
        path: '/admin/CreateVenteGros',
        name: 'CreateVenteGros',
        component: CreateVenteGros,
    },
    {   path: '/admin/VenteServices',
        name: 'VenteServices',
        component: VenteServices,
    },
    {
        path: '/admin/VenteUnite',
        name: 'VenteUnite',
        component: VenteUnite,
    },
    {//Emplacements
        path: '/admin/Services',
        name: 'Services',
        component: ServiceLog,
    },
    {//Emplacements
        path: '/admin/Emplacements',
        name: 'Emplacements',
        component: Emplacements,
    },
    {
        path: '/admin/Agent',
        name: 'Agent',
        component: Agent,
    },
    {
        path: '/admin/CategorieAgent',
        name: 'CategorieAgent',
        component: CategorieAgent,
    },
    {
        path: '/admin/FonctionAgent',
        name: 'FonctionAgent',
        component: FonctionAgent,
    },
    {
        path: '/admin/TypeAgent',
        name: 'TypeAgent',
        component: TypeAgent,
    },
    {
        path: '/admin/CategorieRubriquePers',
        name: 'CategorieRubriquePers',
        component: CategorieRubriquePers,
    },
    {
        path: '/admin/Postes',
        name: 'Postes',
        component: Postes,
    },
    {
        path: '/admin/Mutuelle',
        name: 'Mutuelle',
        component: Mutuelle,
    },
    {
        path: '/admin/TypeCirconstance',
        name: 'TypeCirconstance',
        component: TypeCirconstance,
    },
    {//TypeStage
        path: '/admin/TypeContrat',
        name: 'TypeContrat',
        component: TypeContrat,
    },
    {//TypeStage
        path: '/admin/TypeStage',
        name: 'TypeStage',
        component: TypeStage,
    },
    {
        path: '/admin/LieuAffectation',
        name: 'LieuAffectation',
        component: LieuAffectation,
    },
    {
        path: '/admin/CategorieServicePers',
        name: 'CategorieServicePers',
        component: CategorieServicePers,
    },
    {
        path: '/admin/ServicePersonnel',
        name: 'ServicePersonnel',
        component: ServicePersonnel,
    },
    {
        path: '/admin/CategorieCirconstance',
        name: 'CategorieCirconstance',
        component: CategorieCirconstance,
    },
    {
        path: '/admin/ParametreSalairebBase',
        name: 'ParametreSalairebBase',
        component: ParametreSalairebBase,
    },
    {
        path: '/admin/Annee',
        name: 'Annee',
        component: Annee,
    },
    {
        path: '/admin/Mois',
        name: 'Mois',
        component: Mois,
    },
    {
        path: '/admin/RaisonFamilliale',
        name: 'RaisonFamilliale',
        component: RaisonFamilliale,
    },
    {
        path: '/admin/RubriquePaie',
        name: 'RubriquePaie',
        component: RubriquePaie,
    },
    {
        path: '/admin/ParametreRubrique',
        name: 'ParametreRubrique',
        component: ParametreRubrique,
    },
    {
        path: '/admin/FichePaie',
        name: 'FichePaie',
        component: FichePaie,
    },
    {
        path: '/admin/FichePaieGlobale',
        name: 'FichePaieGlobale',
        component: FichePaieGlobale,
    },
    {
        path: '/admin/RapportsJour_Personnel',
        name: 'RapportsJour_Personnel',
        component: RapportsJour_Personnel,
    },
    {
        path: '/admin/RapportContrat',
        name: 'RapportContrat',
        component: RapportContrat,
    },
    {
        path: '/admin/ProduitLog',
        name: 'ProduitLog',
        component: ProduitLog,
    },
    {
        path: '/admin/Chambre',
        name: 'Chambre',
        component: Chambre,
    },
    {
        path: '/admin/ClasseChambre',
        name: 'ClasseChambre',
        component: ClasseChambre,
    },
    {
        path: '/admin/Salle',
        name: 'Salle',
        component: Salle,
    },
    {
        path: '/admin/ClientHotel',
        name: 'ClientHotel',
        component: ClientHotel,
    },
    { 
        path: '/admin/ReservationAll',
        name: 'ReservationAll',
        component: ReservationAll,
    },
    { 
        path: '/admin/LocationAppartementAll',
        name: 'LocationAppartementAll',
        component: LocationAppartementAll,
    },
    { //
        path: '/admin/DepenseAll',
        name: 'DepenseAll',
        component: DepenseAll,
    },
    {
        path: '/admin/ClientVente',
        name: 'ClientVente',
        component: ClientVente,
    },
    {
        path: '/admin/CategorieClient',
        name: 'CategorieClient',
        component: CategorieClient,
    },
    { 
        path: '/admin/CreateRestoreProduct',
        name: 'CreateRestoreProduct',
        component: CreateRestoreProduct,
    },
    {   
        path: '/admin/VenteEnteteFactureGroupe',
        name: 'VenteEnteteFactureGroupe',
        component: VenteEnteteFactureGroupe,
    },
    {       
        path: '/admin/CreateFactureGroupe',
        name: 'CreateFactureGroupe',
        component: CreateFactureGroupe,
    },
    { 
      // 
        path: '/admin/RapportEntree',
        name: 'RapportEntree',
        component: RapportEntree,
    },
    { 
        path: '/admin/RapportSortie',
        name: 'RapportSortie',
        component: RapportSortie,
    },
    { 
        path: '/admin/CreateAjustement',
        name: 'CreateAjustement',
        component: CreateAjustement,
    },
    { 
        path: '/admin/TranfertUsage',
        name: 'TranfertUsage',
        component: TranfertUsage,
    },
    { 
        path: '/admin/ApprovCommandes',
        name: 'ApprovCommandes',
        component: ApprovCommandes,
    },
    {
        path: '/admin/VenteGrandeCategorieProduit',
        name: 'VenteGrandeCategorieProduit',
        component: VenteGrandeCategorieProduit,
    },
    {//TestExcel
        path: '/admin/TestExcel',
        name: 'TestExcel',
        component: TestExcel,
    },
    {
        path: '/admin/VenteEnteteCommande',
        name: 'VenteEnteteCommande',
        component: VenteEnteteCommande,
    },
    {
        path: '/admin/VenteEnteteEntree',
        name: 'VenteEnteteEntree',
        component: VenteEnteteEntree,
    },
    {
        path: '/admin/VenteEnteteVente',
        name: 'VenteEnteteVente',
        component: VenteEnteteVente,
    },
    {
        path: '/admin/RapportsJour_Vente',
        name: 'RapportsJour_Vente',
        component: RapportsJour_Vente,
    },
    {
        path: '/admin/AllContrat',
        name: 'AllContrat',
        component: AllContrat,
    },
    {
        path: '/admin/ContratsEncours',
        name: 'ContratsEncours',
        component: ContratsEncours,
    },
    {
        path: '/admin/ContratFini',
        name: 'ContratFini',
        component: ContratFini,
    },
    {
      
        path: '/admin/ContratEnconge',
        name: 'ContratEnconge',
        component: ContratEnconge,
    },
    { 
        path: '/admin/ContratActif',
        name: 'ContratActif',
        component: ContratActif,
    },
    { 
        path: '/admin/AllCorrespondance',
        name: 'AllCorrespondance',
        component: AllCorrespondance,
    },
    { 
        path: '/admin/AllTimeSheet',
        name: 'AllTimeSheet',
        component: AllTimeSheet,
    },
    { 
        path: '/admin/JourCorrespondance',
        name: 'JourCorrespondance',
        component: JourCorrespondance,
    },
    { 
        path: '/admin/JourTimeSheet',
        name: 'JourTimeSheet',
        component: JourTimeSheet,
    },
    { 
        path: '/admin/UserCorrespondance',
        name: 'UserCorrespondance',
        component: UserCorrespondance,
    },
    { 
        path: '/admin/UserTimeSheet',
        name: 'UserTimeSheet',
        component: UserTimeSheet,
    },
    { 
      //ImportPresence
        path: '/admin/AllPresenceAgent',
        name: 'AllPresenceAgent',
        component: AllPresenceAgent,
    },
    { 
      //ImportPresence
        path: '/admin/ImportPresence',
        name: 'ImportPresence',
        component: ImportPresence,
    },
    { 
        path: '/admin/JourPresences',
        name: 'JourPresences',
        component: JourPresences,
    },
    {
        path: '/admin/StageEncours',
        name: 'StageEncours',
        component: StageEncours,
    },
    {
        path: '/admin/AllStages',
        name: 'AllStages',
        component: AllStages,
    },
    {
        path: '/admin/RapportsJour_Reservation',
        name: 'RapportsJour_Reservation',
        component: RapportsJour_Reservation,
    },
    {
        path: '/admin/ClotureComptabilite',
        name: 'ClotureComptabilite',
        component: ClotureComptabilite,
    },
    {
        path: '/admin/SalonEnteteVente',
        name: 'SalonEnteteVente',
        component: SalonEnteteVente,
    },
    {
        path: '/admin/SalonProduit',
        name: 'SalonProduit',
        component: SalonProduit,
    },
    {
        path: '/admin/RapportsJour_VenteSalon',
        name: 'RapportsJour_VenteSalon',
        component: RapportsJour_VenteSalon,
    },
    {
        path: '/admin/CarVehicule',
        name: 'CarVehicule',
        component: CarVehicule,
    },
    {
        path: '/admin/CarProduit',
        name: 'CarProduit',
        component: CarProduit,
    },
    {
        path: '/admin/CarProducteur',
        name: 'CarProducteur',
        component: CarProducteur,
    },
    {
        path: '/admin/CarEnteteMouvement',
        name: 'CarEnteteMouvement',
        component: CarEnteteMouvement,
    },
    { //RapportTimeSheet
        path: '/admin/RapportsJour_Vehicule',
        name: 'RapportsJour_Vehicule',
        component: RapportsJour_Vehicule,
    },
    { //Backups
        path: '/admin/RapportTimeSheet',
        name: 'RapportTimeSheet',
        component: RapportTimeSheet,
    },
    { //Backups
        path: '/admin/Backups',
        name: 'Backups',
        component: Backups,
    },
    {
        path: '/admin/ListeMenu',
        name: 'ListeMenu',
        component: ListeMenu,
    },
    {
        path: '/admin/HistoriqueData',
        name: 'HistoriqueData',
        component: HistoriqueData,
    },
    {        
        path: '/admin/GazCreateVente',
        name: 'GazCreateVente',
        component: GazCreateVente,
    },
    {        
        path: '/admin/GazEnteteVente',
        name: 'GazEnteteVente',
        component: GazEnteteVente,
    },
    {        
        path: '/admin/GazEntetepaiementVente',
        name: 'GazEntetepaiementVente',
        component: GazEntetepaiementVente,
    },
    {        
        path: '/admin/GazCreateProduction',
        name: 'GazCreateProduction',
        component: GazCreateProduction,
    },
    {        
        path: '/admin/GazEnteteProduction',
        name: 'GazEnteteProduction',
        component: GazEnteteProduction,
    },
    {        
        path: '/admin/GazTransfertStock',
        name: 'GazTransfertStock',
        component: GazTransfertStock,
    },
    {        
        path: '/admin/GazEnteteUsage',
        name: 'GazEnteteUsage',
        component: GazEnteteUsage,
    },
    {        
        path: '/admin/GazEnteteInventaire',
        name: 'GazEnteteInventaire',
        component: GazEnteteInventaire,
    },
    {        
        path: '/admin/GazCreateInventaire',
        name: 'GazCreateInventaire',
        component: GazCreateInventaire,
    },
    {        
        path: '/admin/GazCreateUsage',
        name: 'GazCreateUsage',
        component: GazCreateUsage,
    },
    { 
      //GazCreateRestoreKit      
        path: '/admin/GazEnteteTransfert',
        name: 'GazEnteteTransfert',
        component: GazEnteteTransfert,
    },
    {     
        path: '/admin/GazCreateRestoreKit',
        name: 'GazCreateRestoreKit',
        component: GazCreateRestoreKit,
    },
    {   
        path: '/admin/RapportGaz',
        name: 'RapportGaz',
        component: RapportGaz,
    },
    {        
        path: '/admin/Lot',
        name: 'Lot',
        component: Lot,
    },
    {        
        path: '/admin/GazCategorieLot',
        name: 'GazCategorieLot',
        component: GazCategorieLot,
    },

// GazCategorieLot 

    
   

    /*
    *
    *===============
    * *
    * *
    * *
    * *
    * fin lien de users
    * liens de users
    * =================

    */


    


















  ],
});


Router.beforeEach(VueRouteMiddleware());
export default Router
