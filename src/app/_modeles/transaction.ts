export interface Transaction{
  id: number;
  code: string;
  montant?: number;
  dateTransfert?:Date;
  type: string;
  client?: {
    id: number;
    nomBeneficiaire: string;
    nomClient: string;
    numeroBeneficiaire: string;
    numeroClient: string;
  };
  partAgenceDepot: number;
  partEntreprise: number;
  partEtat: number;
  partAgenceRetrait: number;
  user:{
    username: string;
    email: string;
    prenom: string;
    telephone: string;
    nom: string;
  }
}
