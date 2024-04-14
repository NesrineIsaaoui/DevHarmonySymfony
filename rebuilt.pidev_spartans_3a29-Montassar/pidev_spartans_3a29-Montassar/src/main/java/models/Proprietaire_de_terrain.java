package models;

public class Proprietaire_de_terrain extends User {
    public Proprietaire_de_terrain(int id, int age, int phone, String role, String date_de_Creation, String email, String address, String password, String name) {
        super(id, age, phone, role, date_de_Creation, email, address, password, name);
    }

    public Proprietaire_de_terrain(String role, String date_de_Creation, String email, String password, String name) {
        super(role, date_de_Creation, email, password, name);
    }

    public Proprietaire_de_terrain() {
    }
}
