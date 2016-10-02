<?php
$formatXSLT = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="xml" omit-xml-declaration="yes"/>
   <xsl:template match="/data">
      <form id="table" action="_page_" method="post">
          <input type="hidden" name="sort" value="_sort_"/>
         <xsl:apply-templates select="groups"/>
         <xsl:apply-templates select="table"/>
         <xsl:apply-templates select="buttons"/>
      </form>
   </xsl:template>
   <!-- Format select list -->
   <xsl:template match="/data/groups">
     <p class="edit">Select: <select id="groupSelect" list="groups" name="gid" onchange="onGroupChange()">
        <option value="0">All Groups</option>
           <xsl:apply-templates select="group"/>
        </select>
     </p>
   </xsl:template>
   <!-- Select list entries from DB -->
   <xsl:template match="/data/groups/group">
      <xsl:choose>
         <xsl:when test="@id = '_gid_'">
            <option value="{@id}" selected="selected"><xsl:value-of select="."/></option>
         </xsl:when>
         <xsl:otherwise>
            <option value="{@id}"><xsl:value-of select="."/></option>
         </xsl:otherwise>
      </xsl:choose>
   </xsl:template>
   <!-- Foramt Table -->
   <xsl:template match="/data/table">
      <table>
         <xsl:apply-templates select="columns"/>
         <xsl:apply-templates select="zoo"/>
      </table>
   </xsl:template>
   <!-- Table colums -->
   <xsl:template match="/data/table/columns">
      <tr>
         <xsl:apply-templates select="entry"/>
      </tr>
   </xsl:template>
   <!-- Table colums from DB -->
   <xsl:template match="/data/table/columns/entry">
      <xsl:choose>
         <xsl:when test="sort = '_sort_'">
            <th>
              <button type="submit" name="sort" value="{sort}" disabled="disabled">
                 <xsl:value-of select="name"/>&#160;▼
              </button>
            </th>
         </xsl:when>
         <xsl:otherwise>
            <th>
              <button type="submit" name="sort" value="{sort}">
                 <xsl:value-of select="name"/>&#160;►
              </button>
            </th>
         </xsl:otherwise>
      </xsl:choose>
   </xsl:template>
   <xsl:template match="/data/table/zoo">
         <xsl:apply-templates select="animal"/>
   </xsl:template>
   <!-- Table body from DB -->
   <xsl:template match="/data/table/zoo/animal">
       <tr>
          <xsl:choose>
              <xsl:when test="(position() mod 2) = 0">
                  <xsl:attribute name="class">even</xsl:attribute>
              </xsl:when>
              <xsl:otherwise>
                  <xsl:attribute name="class">odd</xsl:attribute>
              </xsl:otherwise>
           </xsl:choose>
           <td><xsl:value-of select="."/></td>
           <td><xsl:value-of select="@group"/></td>
           <td class="right"><xsl:value-of select="@count"/></td>
       </tr>
   </xsl:template>
   <!-- Foramt buttons -->
   <xsl:template match="/data/buttons">
        <p class="edit">
           <xsl:choose>
             <xsl:when test="@from &gt; 0">
               <button type="submit" name="button_back" value="Back">&#9664;</button>
                 <input type="hidden" name="BCK" value="{@prev}" />
             </xsl:when>
             <xsl:otherwise>
               <button type="submit" name="button_back" value="Back" disabled="disabled">&#9664;</button>
             </xsl:otherwise>
           </xsl:choose>
           records <xsl:value-of select="@from+1"/> - <xsl:value-of select="@to"/> / <xsl:value-of select="@count"/>
           <xsl:choose>
             <xsl:when test="@more &gt; 0">
               <button type="submit" name="button_next" value="Next">&#9654;</button>
                 <input type="hidden" name="FRD" value="{@next}" />
             </xsl:when>
             <xsl:otherwise>
               <button type="submit" name="button_next" value="Next" disabled="disabled">&#9654;</button>
             </xsl:otherwise>
           </xsl:choose>
        </p> 
   </xsl:template>
</xsl:stylesheet>
XML;

?>
