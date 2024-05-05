package models;

public class Joueur extends User{
    public Joueur(int id, int age, int phone, String role, String date_de_Creation, String email, String address, String password, String name) {
        super(id, age, phone, role, date_de_Creation, email, address, password, name);
    }

    public Joueur(String role, String date_de_Creation, String email, String password, String name) {
        super(role, date_de_Creation, email, password, name);
    }

    public Joueur() {
    }
}
