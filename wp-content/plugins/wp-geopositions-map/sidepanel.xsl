<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<xsl:apply-templates select="location"/>
</xsl:template>
<xsl:template match="location">
<table>
<tr style="cursor:pointer" onclick="showLocationInfo('{@id}')">
<xsl:attribute name="id">
<xsl:value-of select="@id"/>
</xsl:attribute>
<xsl:if test="icon/@class != 'noicon'">
<td style="vertical-align: top; padding-right: 4px;">
<img style="width:24px; height:38px" alt="">
<!-- <xsl:attribute name="src">http://maps.google.com/mapfiles/icon.png</xsl:attribute> -->
<xsl:attribute name="src">
    <xsl:if test="icon/@image != 'http://maps.google.com/mapfiles/marker.png'">

    <xsl:value-of select="icon/@image"/>
    </xsl:if>
    <xsl:if test="icon/@image = 'http://maps.google.com/mapfiles/marker.png'">
    http://maps.google.com/mapfiles/icon.png
    </xsl:if>
</xsl:attribute>
</img>
</td>
</xsl:if>
<td style="padding-bottom: 0.5em; padding-top: 1px; padding-left: 4px">
<xsl:if test="info/title">
<xsl:attribute name="class">label</xsl:attribute>

<div>
<xsl:choose>
<xsl:when test="icon/@class != 'noicon'">
<a href="javascript:void(0)" onclick="this.blur()">
<xsl:attribute name="style">color: #0000cc</xsl:attribute>
<xsl:copy-of select="info/title/node()"/>
</a>
</xsl:when>
<xsl:otherwise>
<xsl:attribute name="style">font-weight: bold</xsl:attribute>
<xsl:copy-of select="info/title/node()"/>
</xsl:otherwise>
</xsl:choose>
</div>
</xsl:if>

<xsl:apply-templates select="info/address/line"/>
</td>
</tr>
</table>
</xsl:template>
<xsl:template match="line">
<div>
<xsl:value-of select="."/>
</div>
</xsl:template>
</xsl:stylesheet>