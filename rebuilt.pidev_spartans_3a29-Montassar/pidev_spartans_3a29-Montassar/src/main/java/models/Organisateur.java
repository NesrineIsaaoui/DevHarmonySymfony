package models;

public class Organisateur extends User{
    private String Nom_Organisation;

    public Organisateur(int id, int age, int phone, String role, String date_de_Creation, String email, String address, String password, String name, String nom_Organisateur) {
        super(id, age, phone, role, date_de_Creation, email, address, password, name);
        this.Nom_Organisation = nom_Organisateur;
    }

    public Organisateur(String role, String date_de_Creation, String email, String password, String name, String nom_Organisateur) {
        super(role, date_de_Creation, email, password, name);
        this.Nom_Organisation = nom_Organisateur;
    }

    public Organisateur(String nom_Organisateur) {
        this.Nom_Organisation = nom_Organisateur;
    }

    public String getNom_Organisation() {
        return Nom_Organisation;
    }

    public void setNom_Organisateur(String nom_Organisateur) {
        this.Nom_Organisation = nom_Organisateur;
    }


}
