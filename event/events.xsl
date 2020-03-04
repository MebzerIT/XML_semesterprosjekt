<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="utf-8" />
  <xsl:template match="/">
      <html>
       <head>
           <meta charset="utf-8" />
           <title>Events</title>
           <link type="text/css" rel="stylesheet" href="css/events.css" />
       </head>
      <body>
             <div class="grid-container">
              <div ></div>
                    <div class="left" style="background-color:#d9d9d9">
                        <h4>Current weather</h4><br/>
                          <div class="big">
                             <p> <xsl:value-of select="document/current/city/@name"/>,<xsl:value-of select="document/current/city/country"/></p>
                             <p><xsl:value-of select="document/current/wind/speed/@name"/></p>
                             <p>Min-Temp: <xsl:value-of select="document/current/temperature/@min"/></p>
                              <p>Max-Temp: <xsl:value-of select="document/current/temperature/@max"/></p>
                             <p>Humidity: <xsl:value-of select="document/current/humidity/@value"/>
                              <xsl:value-of select="document/current/humidity/@unit"/><br/></p>
                          </div><br/>
                          <h4>DNB Exchange rates </h4><br/>
                          <div class="valutaT">
                                  <table >
                                    <tr>
                                      <th>Land</th>
                                      <th>Enhet</th>
                                      <th>ISO</th>
                                      <th>Kjøp</th>
                                      <th>Selg</th>
                                    </tr>
                                    <xsl:for-each select="document/valuta/valutakurs">
                                    <xsl:sort select="kjop" order="descending" />
                                    <xsl:if test="not(position() > 32)">
                                      <tr>
                                        <td><xsl:value-of select="land"/></td>
                                        <td><xsl:value-of select="enhet"/></td>
                                        <td><xsl:value-of select="kode"/></td>
                                        <td><xsl:value-of select="overforsel/kjop"/></td>
                                        <td><xsl:value-of select="overforsel/salg"/></td>
                                      </tr>
                                    </xsl:if>
                                    </xsl:for-each>
                                  </table>
                            </div>
                    </div>
                    <div class="middle" style="background-color:#f2f2f2">
                         <table >
                                <xsl:for-each select="document/events/event">
                                  <tr bgcolor="#e6ecff">
                                    <th bgcolor="#2196F3">Event</th>
                                    <td >
                                         <xsl:variable name="eventUrl" select="url"/>
                                         <a href="{$eventUrl}" target="_blank"><xsl:value-of select="title"/></a>
                                    </td>
                                     <td>
                                        <xsl:variable name="dt" select="start_time"/>
                                         <xsl:value-of select="concat(
                                                substring($dt,9,2),'-',
                                                substring($dt,6,2),'-',
                                                substring($dt,1,4),' ',' &#160;',' &#160;',
                                                substring($dt,12,5))" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <th></th>
                                    <td><xsl:value-of select="venue_name"/></td>
                                  </tr>
                                  <tr>
                                    <th></th>
                                     <td><xsl:value-of select="venue_address"/></td>
                                  </tr>
                                  <tr>
                                    <th></th>
                                     <td><xsl:value-of select="postal_code"/>,<xsl:value-of select="city_name"/></td>
                                  </tr>
                                  <tr class="break">
                                    <th></th>
                                    <td></td>
                                     <td class="break2"></td>
                                   </tr>
                                </xsl:for-each>
                          </table>
                    </div>  
                    <div class="right" style="background-color:#d9d9d9">
                     <h4>Googel Maps | Find an address in <xsl:value-of select="document/current/city/@name"/>,<xsl:value-of select="document/current/city/country"/></h4><br/>
                          <div id="floating-panel">
                              <input id="address" type="textbox" value="Oslo, NO"></input>
                              <input id="submit" type="button" value="Search"></input>
                          </div>
                          <div id="map" style="width:100%;height:50%;"></div>
                        </div>
                    <div class="footer">
                      <p>Copyright© 2019 Events. All rights reserved.</p>
                    </div>
            </div>
      </body>
      </html>
  </xsl:template>
</xsl:stylesheet>
