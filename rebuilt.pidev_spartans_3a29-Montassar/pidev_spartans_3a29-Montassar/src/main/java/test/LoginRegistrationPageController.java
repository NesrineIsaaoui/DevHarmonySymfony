package test;


import javafx.animation.KeyFrame;
import javafx.animation.Timeline;
import javafx.animation.TranslateTransition;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;

import javafx.scene.control.Button;
import javafx.scene.control.PasswordField;
import javafx.scene.control.RadioButton;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;

import javafx.scene.text.Text;
import javafx.util.Duration;



public class LoginRegistrationPageController {

    @FXML
    private Button BtnSinscrire;

    @FXML
    private Button RegisterBtnSinscrire;

    @FXML
    private Text RegisterHeader;

    @FXML
    private Text RegisterLabel1;

    @FXML
    private Text RegisterLabel2;

    @FXML
    private Text RegisteraddressLabel;

    @FXML
    private TextField Registerfield1;

    @FXML
    private TextField Registerfield2;

    @FXML
    private Text Registerlabel12;

    @FXML
    private PasswordField Registerpass1;

    @FXML
    private Text Registertxt2;

    @FXML
    private Text Registrertxt1;

    @FXML
    private AnchorPane RightPane;

    @FXML
    private Text SeconnecterLabel1;

    @FXML
    private Text SeconnecterLabel2;

    @FXML
    private PasswordField SeconnecterPass1;

    @FXML
    private Text SeconnecterTxt1;

    @FXML
    private Text SeconnecterTxt2;

    @FXML
    private Button Seconnecterbtn1;

    @FXML
    private Button Seconnecterbtn2;

    @FXML
    private TextField Seconnecterfield1;

    @FXML
    private Text Seconnecterheader;

    @FXML
    private Button btnSeconnecter;

    @FXML
    private AnchorPane leftPane;

    @FXML
    private RadioButton rbtn1;

    @FXML
    private RadioButton rbtn2;

    @FXML
    private RadioButton rbtn3;

    @FXML
    private RadioButton rbtn4;

    @FXML
    private PasswordField registerPass2;

    public void SinscrireSlideBtn(ActionEvent actionEvent) {

       Seconnecterheader.setVisible(false);
        SeconnecterLabel1.setVisible(false);
        Seconnecterfield1.setVisible(false);
        SeconnecterLabel2.setVisible(false);
        SeconnecterPass1.setVisible(false);
        Seconnecterbtn1.setVisible(false);
        Seconnecterbtn2.setVisible(false);
        SeconnecterTxt1.setVisible(false);
        SeconnecterTxt2.setVisible(false);
        BtnSinscrire.setVisible(false);

        TranslateTransition transition1 = new TranslateTransition(Duration.seconds(1), leftPane);
        transition1.setToX(leftPane.getTranslateX() + 300); // Move left by 50 pixels (adjust as needed)
        TranslateTransition transition2 = new TranslateTransition(Duration.seconds(1), RightPane);
        transition2.setToX(RightPane.getTranslateX() - 880 ); // Move left by 50 pixels (adjust as needed)
        transition1.play();
        transition2.play();


        Timeline timeline = new Timeline(new KeyFrame(Duration.seconds(1), e -> {
            RegisterBtnSinscrire.setVisible(true);
            RegisterHeader.setVisible(true);
            RegisterLabel1.setVisible(true);
            RegisterLabel2.setVisible(true);
            RegisteraddressLabel.setVisible(true);
            Registerfield1.setVisible(true);
            Registerfield2.setVisible(true);
            Registerlabel12.setVisible(true);
            Registerpass1.setVisible(true);
            Registertxt2.setVisible(true);
            Registrertxt1.setVisible(true);
            btnSeconnecter.setVisible(true);
            rbtn1.setVisible(true);
            rbtn2.setVisible(true);
            rbtn3.setVisible(true);
            rbtn4.setVisible(true);
            registerPass2.setVisible(true);
        }));
        timeline.play();


    }

    public void SeconnecterSlideBtn(ActionEvent actionEvent) {

        RegisterBtnSinscrire.setVisible(false);
        RegisterHeader.setVisible(false);
        RegisterLabel1.setVisible(false);
        RegisterLabel2.setVisible(false);
        RegisteraddressLabel.setVisible(false);
        Registerfield1.setVisible(false);
        Registerfield2.setVisible(false);
        Registerlabel12.setVisible(false);
        Registerpass1.setVisible(false);
        Registertxt2.setVisible(false);
        Registrertxt1.setVisible(false);
        btnSeconnecter.setVisible(false);
        rbtn1.setVisible(false);
        rbtn2.setVisible(false);
        rbtn3.setVisible(false);
        rbtn4.setVisible(false);
        registerPass2.setVisible(false);


        TranslateTransition transition1 = new TranslateTransition(Duration.seconds(1), leftPane);
        transition1.setToX(leftPane.getTranslateX() - 300); // Move left by 50 pixels (adjust as needed)
        TranslateTransition transition2 = new TranslateTransition(Duration.seconds(1), RightPane);
        transition2.setToX(RightPane.getTranslateX() + 880); // Move left by 50 pixels (adjust as needed)
        transition1.play();
        transition2.play();

        Timeline timeline = new Timeline(new KeyFrame(Duration.seconds(1), e -> {
            Seconnecterheader.setVisible(true);
            SeconnecterLabel1.setVisible(true);
            Seconnecterfield1.setVisible(true);
            SeconnecterLabel2.setVisible(true);
            SeconnecterPass1.setVisible(true);
            Seconnecterbtn1.setVisible(true);
            Seconnecterbtn2.setVisible(true);
            SeconnecterTxt1.setVisible(true);
            SeconnecterTxt2.setVisible(true);
            BtnSinscrire.setVisible(true);
        }));
        timeline.play();
    }
}
