export interface Transaction{
  id: number;
  code: string;
  dateTransfert?:Date;
  montant?: number;
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


}
