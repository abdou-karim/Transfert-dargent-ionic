export class Compte {
  id: number;
  numeroCompte: string;
  solde?: string;
  dateCreationCompte: string;
  user: {
    avatar: any;
    username: string;
    email: string;
    prenom: string;
    telephone: string;
    nom: string;
  };
  agencePartenaire: {
    email: string;
    adresse: string;
    telephone: string;
    nom: string;
  };
}
