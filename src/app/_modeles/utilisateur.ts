export interface Utilisateur {
  avatar: any;
  username: string;
  email: string;
  prenom: string;
  telephone: string;
  nom: string;
  profile: {
    id: number,
    libelle: string
  };
  agencePartenaire:
    {
      id: number;
      nom: string;
      email: string;
      adresse: string;
      telephone: string;
    };
  token: string;
}
