# imaginacms-isite

## Components

#### Edit Button

The main function of the edit button component is to generate a redirection only for the Page administrators, the component fulfills the function of showing buttons to edit content of the web page from the administrator of the web page, generating support for the administrators when they want to change the content of the page.

The edit button component has required parameters and optional parameters to meet the needs of the clients, the parameters of this component are the following:

| **Params** | **Required** | **Default value** | **Type** | **Options** | **Description** |
| :---: | :---: | :---: | :---: | :---: | :--- |
| `link` | YES | - | Text | `link="/iadmin/#/site/settings?settings=logo1&module=isite"` | In this parameter the editing path of the page administrator is assigned from the domain. |
| `tooltip` | NO | "Edit" | Text | `tooltip="Edit Slider"` | In this parameter a help text is assigned to identify what function the component fulfills, by default the parameter has the phrase "Edit". |
| `classes` | NO | "editLink position-absolute" | Text | `classes="py-5 edit-button-menu"` | In this parameter are the classes that are needed for the styles or column options among others of the button, by default the parameter has the class "editLink position-absolute" which cannot be modified, but the parameter allows adding more classes depending on the need. |
| `top` | NO | "15%" | Percentages or pixels | `top="35%"` | In this parameter the location is assigned on a vertical basis to give a positioning option, by default the parameter has a value of "15%". |
| `bottom` | NO | "unset" | Percentages or pixels | `bottom="35%"` |  In this parameter the location is assigned in vertical base to give a positioning option, by default the parameter has an "unset" value. |
| `right` | NO | "unset" | Percentages or pixels | `right="35%"` | In this parameter the location in horizontal base is assigned to give a positioning option, by default the parameter has an "unset" value. |
| `left` | NO | "15%" | Percentages or pixels | left="35%" | In this parameter the location in horizontal base is assigned to give a positioning option, by default the parameter has a value of "15%". |
| `idButton` | NO | "Null" | Text | idButton="editSlider" | An identifier is assigned in this parameter for the later assignment of styles or any script that is needed, by default the parameter has a "Null" value. |
  
**Applications**

Currently, the edit button is implemented automatically in most components such as sliders among others, since they can be generated automatically, on the other hand, at the moment to generate an edit button of a setting of any module, the following command line must be fulfilled, which will call the edit button and will take us to edit the setting that we need.

  ```ruby
  <x-isite::edit-link link="/iadmin/#/site/settings?settings={{setting_name}}&module={{module_name}}"/> 
  ```

The previous line shows the route that the link parameter must take to make the edit button to any setting, and finally there is an example of the command line to make an edit button of any setting with all the parameters already named above

  ```ruby
  <x-isite::edit-link link="/iadmin/#/site/settings?settings=settingTest&module=icustom" tooltip="Edit Setting settingTest" classes="py-5 edit-button-settingName" top="35%" bottom="15%" right="85%" left="45%" idButton="editSettingTest"/> 
  ```

Remember that optional parameters do not generate errors if they are not sent, otherwise the required parameters can generate an error when assigning them. 

#### Maps

The maps component has the function of rendering maps of desired locations by means of a latitude and longitude of the location, the component can render maps of openstreet and google maps, the choice of the map is made according to a setting in which it is chosen which maps the component is going to use, also remember that to use google maps you must have a key that is entered in another setting from the administrator.

For its correct operation, the component has the following parameters:

| **Params** | **Required** | **Default value** | **Type** | **Options** | **Description** |
| :---: | :---: | :---: | :---: | :---: | :--- |
| `lat` | YES | - | decimal | `lat="4.427950"` | In this parameter, the location is assigned based on the latitude of the site, these measurements are of the decimal type and can be a negative or positive number depending on the location. |
| `lng`	| YES | - | decimal | `lng="-75.213492"` | In this parameter, the location is assigned based on the length of the site, these measurements are of the decimal type and can be a negative or positive number depending on the location. |
| `locationName` | NO | 'Ubicacion' | Text | `locationName="University of Tolima"` | In this parameter, the name of the place to which you want to locate is assigned, this parameter generates a mark on the map which allows users to find the location more efficiently. |
| `title` | NO | Null | Text | `title="University of Tolima, Ibague"` | In this parameter the title of the entire component section is assigned, this parameter can be null and if it is null the title section will be disabled. |
| `zoom` | NO | 16 | Num | `zoom="16"` | In this parameter, the view of the vicinity from which the map will be displayed is assigned, this parameter receives integer numerical values. | 
| `classes` | NO | ' ' | Text | `classes="py-3 maps-university"` | In this parameter are the classes that are needed for the styles or column options among others of the map. |
| `id` | NO | 1 | Num | `id=3` | In this parameter a number is assigned which serves to identify the map, in case there are two different maps on the same page, with this parameter it is sought to completely identify the map and that it can be differentiated from others. |
| `inModal` | NO | false | Boolean | `inModal="true"` |	 In this parameter it is assigned if the component is going to be used in a modal or not, by default the parameter is set to "false", therefore, normally the component is not rendered in modals and that is the function of this parameter. |
| `mapWidth` | NO | `'100%'` | Percentages or pixels | `mapWidth='50%'` | In this parameter it is assigned if the size is width for the map, this parameter receives percentages and measurement values. |
| `mapHeight` | NO | `'314px'` | Percentages or pixels | `mapHeight='314px'` | In this parameter it is assigned if the size is high for the map, this parameter receives percentages and measurement values. |
  
**Applications**

The following example shows how to call the maps component along with all the parameters already mentioned above.

  ```ruby
  <x-isite::Maps lat="4.427950" lng="-75.213492" locationName="University of Tolima" title="University of Tolima, Ibague" zoom="16" classes="py-3 maps-university" id=3 inModal="false" mapWidth='50%' mapHeight='314px'/> 
  ```

