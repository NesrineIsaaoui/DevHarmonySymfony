package models;

public class Fournisseur extends User{

    private String Nom_Societe;

    public String getNom_Societe() {
        return Nom_Societe;
    }

    public void setNom_Societe(String nom_Societe) {
        Nom_Societe = nom_Societe;
    }

    public Fournisseur(int id, int age, int phone, String role, String date_de_Creation, String email, String address, String password, String name, String nom_Societe) {
        super(id, age, phone, role, date_de_Creation, email, address, password, name);
        this.Nom_Societe = nom_Societe;
    }

    public Fournisseur(String role, String date_de_Creation, String email, String password, String name, String nom_Societe) {
        super(role, date_de_Creation, email, password, name);
        this.Nom_Societe = nom_Societe;
    }

    public Fournisseur(String nom_Societe) {
        this.Nom_Societe = nom_Societe;
    }
}
