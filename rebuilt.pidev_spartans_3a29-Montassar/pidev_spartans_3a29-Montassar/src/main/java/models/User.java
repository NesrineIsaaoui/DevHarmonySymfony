package models;


public class User {
    private int id;
    private int age;
    private String image ;
    private int Phone ;
    private String role ;

    private String Date_de_Creation;
    private String Email ;
    private String Address;

    private String Password;
    private String name;

    private String Status = "Active" ;

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public String getDate_de_Creation() {
        return Date_de_Creation;
    }

    public void setDate_de_Creation(String date_de_Creation) {
        this.Date_de_Creation = date_de_Creation;
    }

    public static boolean isValidRole(String input) {
        for (Roles role : Roles.values()) {
            if (role.name().equals(input)) {
                return true;
            }
        }
        return false;
    }

    public String getStatus() {
        return Status;
    }

    public void setStatus(String status) {
        this.Status = status;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
         if(isValidRole(role)){
             this.role = role;
         }

    }


    public String getEmail() {
        return Email;
    }

    public void setEmail(String email) {
        this.Email = email;
    }

    public String getAddress() {
        return Address;
    }

    public void setAddress(String address) {
        this.Address = address;
    }

    public String getPassword() {
        return Password;
    }

    public void setPassword(String password) {
        this.Password = password;
    }

    public int getPhone() {
        return Phone;
    }

    public void setPhone(int phone) {
        this.Phone = phone;
    }



    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public String getName() {
        return name ;   }

    public void setName(String name) {
        this.name = name;    }


    public User(int id, int age, int phone, String role, String date_de_Creation, String email, String address, String password, String name) {
        this.id = id;
        this.age = age;
        this.Phone = phone;
        setRole(role);
        this.Date_de_Creation = date_de_Creation;
        this.Email = email;
        this.Address = address;
        this.Password = password;
        this.name = name;

    }

    public User(String role, String date_de_Creation, String email, String password, String name) {
        setRole(role);
        this.Date_de_Creation = date_de_Creation;
        this.Email = email;
        this.Password = password;
        this.name = name;

    }


    public User(){}

    @Override
    public String toString() {
        return "User{" +
                "id=" + id +
                ", age=" + age +
                ", image='" + image + '\'' +
                ", Phone=" + Phone +
                ", role='" + role + '\'' +
                ", Date_de_Creation=" + Date_de_Creation +'\''+
                ", Email='" + Email + '\'' +
                ", Address='" + Address + '\'' +
                ", Password='" + Password + '\'' +
                ", name='" + name + '\'' +
                ", Status='" + Status + '\'' +
                '}';
    }
}
