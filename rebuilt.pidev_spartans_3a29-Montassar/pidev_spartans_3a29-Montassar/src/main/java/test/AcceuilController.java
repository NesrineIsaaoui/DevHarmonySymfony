package test;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.Pane;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import models.User;
import services.GestionUser.UserService;

import java.io.IOException;
import java.sql.SQLException;

public class AcceuilController {

    @FXML
    private Button btnlogout;

    @FXML
    private Text Username;

    @FXML
    private Button btnseeProfile;

    private User CurrentUser ;
    public void setData(User u) {
        this.CurrentUser = u ;
        Username.setText(u.getName());


    }
    @FXML
    private AnchorPane profileContainer; // This should be a container in your "Acceuil.fxml" to hold the "Profile" view

    @FXML
    void btnseeProfile(ActionEvent event) {
        try {

            FXMLLoader loader = new FXMLLoader(getClass().getResource("Profile.fxml"));
            AnchorPane root = loader.load();


            ProfileController profilecontroler = loader.getController();


            profilecontroler.setData(CurrentUser);

            profileContainer.getChildren().setAll(root);



        } catch (IOException | SQLException e) {
            e.printStackTrace();
        }

    }
    @FXML
    void logoutaction(ActionEvent event) {
        try {
            UserService us = new UserService();

            FXMLLoader loader = new FXMLLoader(getClass().getResource("SeConnecter.fxml"));
            Parent root = loader.load();

            SeconnecterController seconnectercontroller = loader.getController();


            seconnectercontroller.setData(us.getByEmail(CurrentUser.getEmail()));

            Stage stage = new Stage();
            stage.setScene(new Scene(root));
            stage.show();

            ((Stage) btnlogout.getScene().getWindow()).close();

        } catch (IOException e) {
            e.printStackTrace();
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
    }

}
