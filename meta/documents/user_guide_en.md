# ElasticExportCdiscountCOM plugin user guide

<div class="container-toc"></div>

## 1 Registering with Cdiscount.com

Items are sold on the marketplace Cdiscount. For further information about this market, refer to the [Setting up cdiscount](https://knowledge.plentymarkets.com/en/markets/cdiscount) page of the manual.

<div class="alert alert-info" role="alert">
This plugin gives you access to the export format <b>CdiscountCOM</b>. You only need this export format if Cdiscount requests a CSV file containing item data. To sell your products on the market Cdiscount, go to <b>Setup » Markets » Cdiscount.com</b> in the <a href="https://knowledge.plentymarkets.com/maerkte/cdiscount" target="_blank">plentymarkets backend</a>.
</div>

## 2 Setting up the data format CdiscountCOM-Plugin in plentymarkets

By installing this plugin you will receive the export format **CdiscountCOM-Plugin**. Use this format to exchange data between plentymarkets and Cdiscount.com. It is required to install the Plugin Elastic export from the plentyMarketplace first before you can use the format **CdiscountCOM-Plugin** in plentymarkets.

Once both plugins are installed, you can create the export format **CdiscountCOM-Plugin**. Refer to the [Elastic Export](https://knowledge.plentymarkets.com/en/data/exporting-data/elastic-export) page of the manual for further details about the individual format settings.

Creating a new export format:

1. Go to **Data » Elastic export**.
2. Click on **New export**.
3. Carry out the settings as desired. Pay attention to the information given in table 1.
4. **Save** the settings.<br/>
→ The export format will be given an ID and it will appear in the overview within the **Exports** tab.

The following table lists details for settings, format settings and recommended item filters for the format **CdiscountCOM-Plugin**.

| **Setting**                                           | **Explanation** |
| :---                                                  | :--- |
| **Settings**                                          | |
| **Name**                                              | Enter a name. The export format will be listed under this name in the overview within the **Exports** tab. |
| **Type**                                              | Select the type **Item** from the drop-down list. |
| **Format**                                            | Select **CdiscountCOM-Plugin**. |
| **Limit**                                             | Enter a number. If you want to transfer more than 9,999 data records to the price search engine, then the output file will not be generated again for another 24 hours. This is to save resources. If more than 9,999 data records are necessary, the setting **Generate cache file** has to be active. |
| **Generate cache file**                               | Place a check mark if you want to transfer more than 9,999 data records to the price search engine. The output file will not be generated again for another 24 hours. We recommend not to activate this setting for more than 20 export formats. This is to save resources. |
| **Provision**                                         | Select **URL**. This option generates a token for authentication in order to allow external access. |
| **Token, URL**                                        | If you have selected the option **URL** under **Provisioning**, then click on **Generate token**. The token will be entered automatically. When the token is generated under **Token**, the URL is entered automatically. |
| **File name**                                         | The file name must have the ending **.csv** for Cdiscount.com to be able to import the file successfully. |
| **Item filter**                                       | |
| **Add item filters**                                  | Select an item filter from the drop-down list and click on **Add**. There are no filters set in default. It is possible to add multiple item filters from the drop-down list one after the other.<br/> **Variations** = Select **Transfer all** or **Only transfer main variations**.<br/> **Markets** = Select **Cdiscount.com**.<br/> The availability for all markets selected here has to be saved for the item. Otherwise, the export will not take place.<br/> **Currency** = Select a currency.<br/> **Category** = Activate to transfer the item with its category link. Only items belonging to this category will be exported.<br/> **Image** = Activate to transfer the item with its image. Only items with images will be transferred.<br/> **Client** = Select client.<br/> **Stock** = Select which stocks you want to export.<br/> **Flag 1 - 2** = Select the flag.<br/> **Manufacturer** = Select one, several or **ALL** manufacturers.<br/> **Active** = Only active variations will be exported. |
| **Format settings**                                   | |
| **Product URL**                                       | Choose wich URL should be transferred to the price comparison portal, the item’s URL or the variation’s URL. Variation SKUs can only be transferred in combination with the Ceres store. |
| **Client**                                            | Select a client. This setting is used for the URL structure. |
| **URL parameter**                                     | Enter a suffix for the product URL if this is required for the export. If you have activated the transfer option for the product URL further up, then this character string will be added to the product URL. |
| **Order referrer**                                    | Select **Cdiscount.com**. The selected referrer is added to the product URL so that sales can be analysed later. |
| **Marketplace account**                               | Select the marketplace account from the drop-down list. |
| **Language**                                          | Select the language from the drop-down list. |
| **Item name**                                         | Select **Name 1**, **Name 2** or **Name 3**. These names are saved in the **Texts** tab of the item. Enter a number into the **Maximum number of characters (def. Text)** field if desired. This specifies how many characters should be exported for the item name. |
| **Preview text**                                      | This option does not affect this format |
| **Description**                                       | Select the text that you want to transfer as description.<br/> Enter a number into the **Maximum number of characters (def. text)** field if desired. This specifies how many characters should be exported for the description.<br/> Activate the option **Remove HTML tags** if you want HTML tags to be removed during the export. If you only want to allow specific HTML tags to be exported, then enter these tags into the field **Permitted HTML tags, separated by comma (def. Text)**. Use commas to separate multiple tags. |
| **Target country**                                    | Select the target country from the drop-down list. |
| **Barcode**                                           | Select the ASIN, ISBN or an EAN from the drop-down list. The barcode has to be linked to the order referrer selected above. If the barcode is not linked to the order referrer it will not be exported. |
| **Image**                                             | Select **First image**. |
| **Image position of the energy efficiency label**     | This option does not affect this format. |
| **Stockbuffer**                                       | The stock buffer for variations with the limitation to the net stock. |
| **Stock for variations without stock limitation**     | The stock for variations without stock limitation. |
| **Stock for variations with no stock administration** | The stock for variations without stock administration. |
| **Live currency conversion**                          | This option does not affect this format. |
| **Retail price**                                      | This option does not affect this format. |
| **Offer price**                                       | This option does not affect this format. |
| **RRP**                                               | This option does not affect this format. |
| **Shipping costs**                                    | This option does not affect this format. |
| **VAT note**                                          | This option does not affect this format. |
| **Item availability**                                 | This option does not affect this format. |

## 3 Available columns of the export file

Go to **Data » Elastic export** and open the data format **CdiscountCOM-Plugin** in order to download the export file.

| **Column description**    | **Explanation** |
| :---                      | :--- |
| **Sku parent**            | **Required**<br/> The **Parent SKU** of the variation. |
| **Your reference**        | **Required**<br/> The **SKU** of the variation. |
| **EAN**                   | **Required**<br/> According to the format setting **Barcode**. |
| **Brand**                 | **Required**<br/> The **name of the manufacturer** of the item. The **external name** within **Settings » Items » Manufacturer** will be preferred if existing. |
| **Nature of product**     | **Required**<br/> The product type of a variation. This field defines whether a variation is a single item or a variation of an item. |
| **Category code**         | **Required**<br/> The **category path** of the standard category for the client configured in the format settings. |
| **Basket short wording**  | **Required**<br/> According to the format setting **Item name**. |
| **Basket long wording**   | **Required**<br/> According to the format setting **Preview text**. |
| **Product description**   | **Required**<br/> According to the format setting **Description**. |
| **Picture 1 (jpeg)**      | **Required**<br/> First image of the variation. |
| **Size**                  | The size. According to the property **size** which is configured for the item. |
| **Marketing color**       | The color. According to the property **color** which is configured for the item. |
| **Marketing description** | The marketing description. According to the property **size** which is configured for the item. |
| **Picture 2 (jpeg)**      | Second image of the variation. |
| **Picture 3 (jpeg)**      | Third image of the variation. |
| **Picture 4 (jpeg)**      | Fourth image of the variation. |
| **ISBN / GTIN**           | The ISBN of the variation. |
| **MFPN**                  | The model of the variation. |
| **Length**                | The length of the variation in centimeter. |
| **Width**                 | The width of the variation in centimeter. |
| **Height**                | The height of the variation in centimeter. |
| **Weight**                | The weight of the variation in kilogram. |
| **Main color**            | The color. According to the property **main_color** which is configured for the item. |
| **Gender**                | The gender. According to the property **gender** which is configured for the item. |
| **Type of public**        | The target group. According to the property **type_of_public** which is configured for the item. |
| **Sports**                | According to the property **sports** which is configured for the item. |
| **Comment**               | According to the property **comment** which is configured for the item. |

## 4 Licence

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-cdiscount-com/blob/master/LICENSE.md).
