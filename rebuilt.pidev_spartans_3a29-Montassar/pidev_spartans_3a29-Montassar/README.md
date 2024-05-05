## Requirements

- JDK 17: Make sure you have Java Development Kit (JDK) version 17 or later installed on your system. You can download it from [here](https://www.oracle.com/java/technologies/javase-jdk17-downloads.html).

- Latest SceneBuilder: The project uses JavaFX for the user interface. You will need the latest version of SceneBuilder to design and edit the user interface. You can download SceneBuilder from [here](https://gluonhq.com/products/scene-builder/).

- If you encounter any issues or errors while setting up or running the project, you can try the following steps:

1. **Check JDK Configuration**: Ensure that your IDE is configured to use JDK 17. You may need to update the JDK configuration in your IDE settings.

2. **Download Latest SceneBuilder**: Make sure you have the latest version of SceneBuilder installed. Sometimes compatibility issues arise with older versions.

3. **Use Provided Settings**: If you're still experiencing issues, you can use the provided settings file to configure your IDE. https://drive.google.com/file/d/10CKQhAumXekzBJLediZ31yPccS_Crj8S/view?usp=sharing

    - **Step 1**: Export your current IDE settings by navigating to `File` > `Manage IDE Settings` > `Export Settings` (in case of the provided settings don't work you can rollback).

    - **Step 2**: Import the provided settings file by navigating to `File` > `Manage IDE Settings` > `Import Settings`.
4. OpenJFX SDK: Download OpenJFX SDK from here and extract it. [here](https://download2.gluonhq.com/openjfx/21.0.2/openjfx-21.0.2_windows-x64_bin-sdk.zip)
 
    -Open the run configuration in your IDE by navigating to Run > Edit Configurations.
   
    -In the Modify options section in the Build and Run section on the top right, add VM options.
   
    -Add the path to the lib folder from the extracted OpenJFX SDK. This is necessary for JavaFX to run properly.
