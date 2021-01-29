# WebHooks

https://zakeke.zendesk.com/hc/en-us/articles/360025019933-WebHooks
<br>
https://order.mydesignlist.com/WebHooks/

Workflows:
1. Get the following info via webhooks and then store them into the MySQL database on the server:
orderCode （unique）
detailModelCode （it may have multiple detailModelCode related to one orderCode）
fileUrl （PNG format and Zip format，it may have multiple fileUrls(both for PNG format and Zip format) related to one orderCode）

2. Download all the PNG files and all the Zip files to the server

3. Create a simple webpage to let us search all the fileUrls with the orderCode (we input the orderCode on the webpage, all the fileUrls which related to this orderCode will be shown to us after we clicked the search button, one row one fileUrl).
