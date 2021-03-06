export interface Transaction{
  id: number;
  code: string;
  montant?: number;
  dateTransfert?:Date;
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
