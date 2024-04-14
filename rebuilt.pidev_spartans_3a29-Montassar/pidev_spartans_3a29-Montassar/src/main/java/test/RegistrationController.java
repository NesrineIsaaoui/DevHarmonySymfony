package test;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import models.*;
import org.w3c.dom.events.MouseEvent;
import services.GestionUser.UserService;

import java.io.IOException;
import java.sql.Date;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.Objects;
import java.util.ResourceBundle;

public class RegistrationController {
    UserService us = new UserService();

    @FXML
    private Button btnSeconnecter;



    @FXML
    private Button btnsinscrire;

    @FXML
    private RadioButton rbtnfournisseur;

    @FXML
    private RadioButton rbtnjoueur;

    @FXML
    private RadioButton rbtnorganisateur;

    @FXML
    private RadioButton rbtnpropriéte;

    @FXML
    private PasswordField tdconfirmermotdepass;

    @FXML
    private PasswordField tdmotdepass;

    @FXML
    private TextField tfaddresselectronique;

    @FXML
    private TextField tfnom;

    @FXML
    private AnchorPane RegistrationLeftPane;

    @FXML
    private AnchorPane RegistrationPane;

    @FXML
    private AnchorPane RegistrationRightPane;
    @FXML
    void openseconnectertab(ActionEvent event) {
        try {

            FXMLLoader loader = new FXMLLoader(getClass().getResource("SeConnecter.fxml"));
            AnchorPane root = loader.load();

            SeconnecterController seconnectercontroller = loader.getController();

               RegistrationPane.getChildren().setAll(root);




        } catch (IOException e) {
            e.printStackTrace();
        }

    }



    @FXML
    void sinscrire(ActionEvent event) throws SQLException {

        if (tfaddresselectronique.getText().equals("")
                || tfnom.getText().equals("")
                || tdmotdepass.getText().equals("")){
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("Champ vide");
            alert.setContentText("vous pouvez les remplir soigneusement");
            alert.setHeaderText("Tous les champs sont requis");
            alert.showAndWait();
            tfnom.setText("");
            tfaddresselectronique.setText("");
            tdmotdepass.setText("");
            tdconfirmermotdepass.setText("");
            return;
        }
        if(!tdmotdepass.getText().equals(tdconfirmermotdepass.getText()) ){
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("mots de passe ne correspondent pas");
            alert.setContentText("mot de passe et confirmer le mot de mot de passe devraient avoir le même contenu");
            alert.setHeaderText("Warning Alert");
            alert.showAndWait();
            tfnom.setText("");
            tfaddresselectronique.setText("");
            tdmotdepass.setText("");
            tdconfirmermotdepass.setText("");
            return;
        }
        if(us.userExist(tfaddresselectronique.getText())){
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("l'utilisateur existe déjà");
            alert.setContentText("Il y a déjà un utilisateur avec cet e-mail");
            alert.setHeaderText("Warning Alert");
            alert.showAndWait();
            tfnom.setText("");
            tfaddresselectronique.setText("");
            tdmotdepass.setText("");
            tdconfirmermotdepass.setText("");
            return;
        }


            String role;
          User u1;
            if(rbtnfournisseur.isSelected()){
                role = "Fournisseur" ;
                LocalDate currentDate = LocalDate.now();
                DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
                String dateString = currentDate.format(formatter);


                u1 = new Fournisseur(role,dateString,tfaddresselectronique.getText(),tdmotdepass.getText(),tfnom.getText(),"");
                us.addFournisseur((Fournisseur) u1);
            } else if (rbtnpropriéte.isSelected()) {
                role = "Proprietaire_de_Terrain";
                LocalDate currentDate = LocalDate.now();
                DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
                String dateString = currentDate.format(formatter);

                 u1 = new Proprietaire_de_terrain(role,dateString,tfaddresselectronique.getText(),tdmotdepass.getText(),tfnom.getText());
                us.addProprietairedeTerarin((Proprietaire_de_terrain) u1);
            } else if (rbtnorganisateur.isSelected()) {
                role = "Organisateur";
                LocalDate currentDate = LocalDate.now();
                DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
                String dateString = currentDate.format(formatter);

                 u1 = new Organisateur(role,dateString,tfaddresselectronique.getText(),tdmotdepass.getText(),tfnom.getText(),"");
                us.addOrganisateur((Organisateur)u1);
            }else{
                role = "Joueur";
                LocalDate currentDate = LocalDate.now();
                DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
                String dateString = currentDate.format(formatter);

                 u1 = new Joueur(role,dateString,tfaddresselectronique.getText(),tdmotdepass.getText(),tfnom.getText());
                us.addJoueur((Joueur)u1);
            }



                Alert alert = new Alert(Alert.AlertType.INFORMATION);
                alert.setTitle("Compte créé avec succès");
                alert.setHeaderText("Votre Compte a été créé avec succès");
                alert.showAndWait();
        try {

            FXMLLoader loader = new FXMLLoader(getClass().getResource("SeConnecter.fxml"));
            Parent root = loader.load();

            SeconnecterController seconnectercontroller = loader.getController();

            seconnectercontroller.setData(u1);

            Stage stage = new Stage();
            stage.setScene(new Scene(root));
            stage.show();

            ((Stage) btnSeconnecter.getScene().getWindow()).close();

        } catch (IOException e) {
            e.printStackTrace();
        }




    }

}
