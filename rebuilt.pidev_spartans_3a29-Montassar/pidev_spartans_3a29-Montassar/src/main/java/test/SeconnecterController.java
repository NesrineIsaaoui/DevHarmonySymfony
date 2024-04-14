package test;

import javafx.animation.TranslateTransition;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.image.ImageView;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import javafx.util.Duration;
import models.User;
import services.GestionUser.UserService;

import java.io.IOException;
import java.sql.SQLException;
import java.util.Optional;


public class SeconnecterController {

    @FXML
    private Button twitterlinkbtn;
    @FXML
    private Button facebooklinkbtn;
    @FXML
    private Button forgetpasswordbutton;

    @FXML
    private Button sinscrirebutton;

    @FXML
    private Button submitbutton;

    @FXML
    private TextField tfaddress;

    @FXML
    private PasswordField tfmotdepass;
    UserService  Us = new UserService();
    @FXML
    void forgetpassword(ActionEvent event) {
        System.out.println("forgetpassword");
    }

    private User CurrentUser ;
    public void setData(User us) {

        this.CurrentUser = us;
        tfaddress.setText(us.getEmail());
        tfmotdepass.setText(us.getPassword());
    }
    @FXML
    private AnchorPane SeconnecterLeftPane;

    @FXML
    private AnchorPane SeconnecterPane;

    @FXML
    private AnchorPane SeconnecterRightPane;


    @FXML
    private ImageView imgviewid;
    @FXML
    private AnchorPane imgpane;

    @FXML
    void sinscrire(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("Registration.fxml"));
            AnchorPane root = loader.load();
            RegistrationController registrationController = loader.getController();

            TranslateTransition transition = new TranslateTransition(Duration.seconds(1), SeconnecterLeftPane);
            transition.setToX(SeconnecterLeftPane.getTranslateX() - 850); // Move left by 50 pixels (adjust as needed)
            TranslateTransition transition1 = new TranslateTransition(Duration.seconds(1),imgpane);
            transition1.setToX(imgpane.getTranslateX() - 417); // Move left by 50 pixels (adjust as needed)
            TranslateTransition transition2 = new TranslateTransition(Duration.seconds(1),SeconnecterRightPane);
            transition2.setToX(SeconnecterRightPane.getTranslateX() + 235); // Move left by 50 pixels (adjust as needed)
            transition.play();
            transition1.play();
            transition2.play();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    public boolean showConfirmationDialog(String message) {
        Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
        alert.setTitle("Confirmation");
        alert.setHeaderText(null);
        alert.setContentText(message);


        Optional<ButtonType> result = alert.showAndWait();
        return result.isPresent() && result.get() == ButtonType.OK;
    }
    @FXML
    void submit(ActionEvent event) throws SQLException {
        if(tfaddress.getText().equals("") || tfmotdepass.getText().equals("")){
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("Champ vide");
            alert.setHeaderText("Tous les champs sont requis");
            alert.showAndWait();
            return;
        }
        if (!Us.Login(tfaddress.getText(),tfmotdepass.getText())) {
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("Champ invalid");
            alert.setHeaderText("L'un des champs est incorrect");
            alert.showAndWait();
            return;
        }
        User u = Us.getByEmail(tfaddress.getText());
        if( u.getStatus().equals("Desactive")){
            if( showConfirmationDialog("Your account is currently deactivated. Do you want to reactivate and log in?")){
                Us.InvertStatus(u.getEmail());
                try {

                    FXMLLoader loader = new FXMLLoader(getClass().getResource("Acceuil.fxml"));
                    Parent root = loader.load();


                    AcceuilController acceuilController = loader.getController();


                    acceuilController.setData(Us.getByEmail(tfaddress.getText()));



                    Stage stage = new Stage();
                    stage.setScene(new Scene(root));
                    stage.show();

                    ((Stage) sinscrirebutton.getScene().getWindow()).close();

                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }else{
            try {

                FXMLLoader loader = new FXMLLoader(getClass().getResource("Acceuil.fxml"));
                Parent root = loader.load();


                AcceuilController acceuilController = loader.getController();


                acceuilController.setData(Us.getByEmail(tfaddress.getText()));



                Stage stage = new Stage();
                stage.setScene(new Scene(root));
                stage.show();

                ((Stage) sinscrirebutton.getScene().getWindow()).close();

            } catch (IOException e) {
                e.printStackTrace();
            }
        }


    }


    @FXML
    void twitterlink(ActionEvent event) {
        openWebpage("https://twitter.com/your_twitter_handle");
    }
    @FXML
    void facebooklink(ActionEvent event) {
        openWebpage("https://www.facebook.com/your_facebook_page");
    }
    private void openWebpage(String url) {
        try {
            Runtime.getRuntime().exec("cmd.exe /c start " + url);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }



}
