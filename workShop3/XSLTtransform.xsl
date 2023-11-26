<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <body>
  <h2>Quote Collection</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th>quote</th>
      <th>source</th>
      <th>dob-dod</th>
      <th>category</th>
    </tr>
    <xsl:for-each select="data/record">
    <tr>
      <td><xsl:value-of select="quote"/></td>
      <td><xsl:value-of select="source"/></td>
      <td><xsl:value-of select="dob-dod"/></td>
      <td><xsl:value-of select="category"/></td>
    </tr>
    </xsl:for-each>
  </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>