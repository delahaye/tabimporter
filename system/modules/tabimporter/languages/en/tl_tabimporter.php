<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 * @license    LGPL
 * @filesource
 */

/**
 * Tabimporter
 */

$GLOBALS['TL_LANG']['tl_tabimporter']['jobtitle'] 					= 'Import-Job ID %s';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobstart'] 					= 'Der Import-Job ´<strong>%s</strong>´ wird gestartet. Bitte unterbrechen Sie den Lauf nicht, um ein unvorhersehbares Verhalten zu vermeiden. Sollte der Job fehlschlagen, können im Anschluss die veränderten Datentabellen wiederhergestellt werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['errorMessageNotFound'] 		= 'Der Import-Job %s wurde nicht gefunden, es kann nichts importiert werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobstartSubmit'] 			= 'Import-Job starten';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobstartSim'] 				= 'Job nur simulieren (nicht empfohlen bei Hookfunktionen)';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobSim'] 					= '<div style="color: red;">Job wird simuliert.</div>';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobSimLog'] 					= 'Simulation: ';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobendSubmit'] 				= 'weiter';
$GLOBALS['TL_LANG']['tl_tabimporter']['nextLink'] 					= 'Klicken Sie hier für den nächsten Schritt, falls Sie Javascript deaktiviert haben.';
$GLOBALS['TL_LANG']['tl_tabimporter']['execTime'] 					= 'Laufzeit: %s Sekunden';
$GLOBALS['TL_LANG']['tl_tabimporter']['loading'] 					= 'Bitte warten Sie, während der Importjob ausgeführt wird.';
$GLOBALS['TL_LANG']['tl_tabimporter']['complete'] 					= 'Der Import-Job wurde beendet. Sie können nun fortfahren.';
$GLOBALS['TL_LANG']['tl_tabimporter']['errorMessage'] 				= 'Der Import-Job wurde wegen Fehlern abgebrochen, es wurde nicht importiert.';
$GLOBALS['TL_LANG']['tl_tabimporter']['errorMessageNotRecorded'] 	= 'Der Import-Job konnte nicht aufgezeichnet werden, es wurde nichts importiert.';
$GLOBALS['TL_LANG']['tl_tabimporter']['init'] 						= 'Initialisierung';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobfound_fail'] 				= 'Job %s wurde nicht gefunden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['jobtracking_fail'] 			= 'Job %s konnte nicht getrackt werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['backup_ok'] 					= 'Sicherungskopie von Tabelle %s erzeugt.';
$GLOBALS['TL_LANG']['tl_tabimporter']['backup_fail'] 				= 'Sicherungskopie von Tabelle %s konnte nicht erzeugt werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['steps'] 						= 'Importschritte';
$GLOBALS['TL_LANG']['tl_tabimporter']['stepfound_fail'] 			= 'Step %s von Job %s wurde nicht gefunden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['csv_fail'] 					= 'CSV-Daten konnten nicht eingelesen werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['update_existent_ok'] 		= 'Vorhandene Datensätze in Tabelle %s ermittelt.';
$GLOBALS['TL_LANG']['tl_tabimporter']['update_existent_fail'] 		= 'Vorhandene Datensätze in Tabelle %s konnten nicht ermittelt werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['update_existent_detail'] 	= 'Anzahl: %s<br>Key ´%s´: ';
$GLOBALS['TL_LANG']['tl_tabimporter']['truncate_ok'] 				= 'Tabelle %s geleert.';
$GLOBALS['TL_LANG']['tl_tabimporter']['truncate_fail'] 				= 'Tabelle %s konnte nicht geleert werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['missing_ok'] 				= 'Tabelle %s: nicht mehr vorhandene Datensätze gelöscht.';
$GLOBALS['TL_LANG']['tl_tabimporter']['missing_fail'] 				= 'Tabelle %s: Löschfehler bei nicht mehr vorhandenen Datensätzen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['existent_ok'] 				= 'Tabelle %s: bereits vorhandene Datensätze gelöscht.';
$GLOBALS['TL_LANG']['tl_tabimporter']['existent_fail'] 				= 'Tabelle %s: Löschfehler bei bereits vorhandenen Datensätzen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['specified_ok'] 				= 'Tabelle %s: spezifizierte Datensätze gelöscht.';
$GLOBALS['TL_LANG']['tl_tabimporter']['specified_fail'] 			= 'Tabelle %s: Löschfehler bei spezifizierten Datensätzen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['updates_ok'] 				= 'Vorhandene Datensätze in Tabelle %s aktualisiert (- %s).';
$GLOBALS['TL_LANG']['tl_tabimporter']['updates_fail'] 				= 'Vorhandene Datensätze in Tabelle %s konnten nicht vollständig aktualisiert werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['inserts_ok'] 				= 'Neue Datensätze in Tabelle %s eingefügt (- %s).';
$GLOBALS['TL_LANG']['tl_tabimporter']['inserts_fail'] 				= 'Nicht alle neuen Datensätze in Tabelle %s konnten eingefügt werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['sql_ok'] 					= 'SQL-Abfrage ausgeführt.';
$GLOBALS['TL_LANG']['tl_tabimporter']['sql_fail'] 					= 'SQL-Abfrage fehlgeschlagen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['hook_ok'] 					= '%s: abgeschlossen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['hook_fail'] 					= '%s: fehlgeschlagen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['final'] 						= 'Finalisierung';
$GLOBALS['TL_LANG']['tl_tabimporter']['new_ok'] 					= 'Neue Version von Tabelle %s aktiviert.';
$GLOBALS['TL_LANG']['tl_tabimporter']['new_fail'] 					= 'Neue Version von Tabelle %s konnte nicht erzeugt werden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['details'] 					= 'Details';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_title'] 				= 'Wiederherstellung';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_description'] 		= 'Bitte beachten: Nicht jeder Import lässt sich 1:1 rückabwickeln. Dies hängt damit zusammen, dass z.B. Dateien verschoben oder andere - nicht auf direkte Contao-Tabellen bezogene - Aktionen ausgeführt werden können. Sie können hier allerdings die im Laufe der Importjobs veränderten Contao-Tabellen auf alte Stände zurücksetzen. Wählen Sie dazu für jede Tabelle aus, welche Kombination von Ständen die höchste Wahrscheinlichkeit für eine erfolgreiche Wiederherstellung bietet. Wenn das nicht funktioniert, sollte ein Backup - z.B. über den Provider - vorhanden sein.';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_submit'] 			= 'Wiederherstellen';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_tablename'] 			= 'Tabelle';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_nothing'] 			= 'Keine Wiederherstellungs-Informationen vorhanden.';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_keep'] 				= 'Aktuelle Version beibehalten';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_tables_ok'] 			= 'Tabelle(n) auf folgende Stände wiederhergestellt:';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_tables_error'] 		= 'Tabelle(n) %s nicht wiederhergestellt.';
$GLOBALS['TL_LANG']['tl_tabimporter']['restore_tables_fatal'] 		= 'Tabelle(n) %s sind endgültig verloren. Backup-Einspielung erforderlich!';
$GLOBALS['TL_LANG']['tl_tabimporter']['warnings'] 					= 'Warnungen';
$GLOBALS['TL_LANG']['tl_tabimporter']['errors'] 					= 'Fehler';
$GLOBALS['TL_LANG']['tl_tabimporter']['update'] 					= 'Aktualisiert';
$GLOBALS['TL_LANG']['tl_tabimporter']['insert'] 					= 'Eingefügt';
$GLOBALS['TL_LANG']['tl_tabimporter']['datasets'] 					= 'Datensätze';
$GLOBALS['TL_LANG']['tl_tabimporter']['SQL'] 						= 'SQL';
$GLOBALS['TL_LANG']['tl_tabimporter']['fieldcount_fail'] 			= '<span class="tl_tabimporter_error">Fehler:</span> Feldanzahl nicht korrekt (Importzeile %s)';
$GLOBALS['TL_LANG']['tl_tabimporter']['no_hit'] 					= 'Kein Datensatz betroffen.';
$GLOBALS['TL_LANG']['tl_tabimporter']['sql_error'] 					= '<span class="tl_tabimporter_warn">Warnung:</span> SQL-Abfrage Feld %s hat Fehler. (Importzeile %s, Key %s=´%s´)';
$GLOBALS['TL_LANG']['tl_tabimporter']['update_error'] 				= 'SQL-Updatefehler<br>Tabelle %s_tabimport<br>Key ´%s´ = %s<br>Importzeile %s';
$GLOBALS['TL_LANG']['tl_tabimporter']['countup_error'] 				= '<span class="tl_tabimporter_warn">Warnung:</span> Hochzähl-Feld %s hat Fehler. (Importzeile %s, Key %s=´%s´)';
$GLOBALS['TL_LANG']['tl_tabimporter']['sql_inserterror'] 			= 'SQL-Einfügefehler<br>Tabelle %s_tabimport<br>Key ´%s´ = %s<br>Importzeile %s';
$GLOBALS['TL_LANG']['tl_tabimporter']['fielderror_int'] 			= 'Wert für %s ist nicht Integer.';
$GLOBALS['TL_LANG']['tl_tabimporter']['fielderror_char'] 			= 'Wert für %s ist zu lang.';
$GLOBALS['TL_LANG']['tl_tabimporter']['howto_title'] 				= 'Import-Jobs';
$GLOBALS['TL_LANG']['tl_tabimporter']['howto_description'] 			= '
<h3>Allgemeines</h3>
<p>Es kann in beliebige Tabellen der Contao-Installation importiert werden. Als Quelle dienen andere Tabellen der Installation oder CSV-Dateien. <strong>Achtung!</strong> Die Erweiterung ist für Admins, Programmierer und Agenturen gedacht. Jeder hierüber ausgeführte Import kann die Contao-Installtion irreparabel beschädigen!</p>
<p>Am Beginn eines Jobs werden alle Zieltabellen in temporäre Versionen kopiert. Alle Änderungen finden in den kopierten Tabellen statt, die - sofern kein zum Abbruch qualifizierender Fehler aufgetreten ist - am Ende des Jobs die Originaltabellen ersetzen. Diese Tabellen erhalten einen um "_tabimport" erweiterten Namen und können so auch in den Importschritten genutzt werden.</p>
<h3>Einrichtung</h3>
<p>
<ul>
<li>Importjob anlegen</li>
<li>Tabellenimporte anlegen<br>(<strong>Hinweis</strong>: "Speichern und schließen" legt schon mal alle erkannten Felddefinitionen für das Mapping an!)</li>
<li>Importschritte anlegen</li>
</ul>
</p>
<p>Zu einem Job gehören 1-x Importschritte, die in der angegebenen Reihenfolge ausgeführt werden. Es stehen mehrere Arten von Schritten zur Verfügung.</p>
<ul>
<li><strong>Definierten Tabellenimport ausführen:</strong> Zu jedem Job können beliebig viele Tabellen-Definitionen angelegt werden. Hierin werden Felder gemappt und festgelegt, wie die Daten für die Zieltabelle ermittelt werden sollen. Beim CSV-Import empfiehlt es sich ggf., die Datei zunächst 1:1 in eine Tabelle einzulesen (die ggf. mit dem Katalogmodul erzeugt werden kann). Nicht vergessen: Ein Tabellenimport muss nicht nur angelegt, sondern auch im Importschritt eingetragen werden. Tabellendefinitionen können auch genutzt werden, um (Ziel-)Tabellen lediglich zu leeren.
<br><br>Es ist nicht nötig, jeweils alle Felder der Quelle oder des Ziels zu nutzen, was nicht benötigt wird, kann wegfallen.
<br><br>Für die Neuanlage und Updates stehen diverse Umformungsmöglichkeiten für die Daten zur Verfügung. Alles, was man über die vorgegebenen Möglichkeiten nicht abbilden kann, lässt sich über SQL-Abfragen oder Hook-Funktionen (s.u.) abbilden.</li>
<li><strong>SQL-Abfrage ausführen:</strong> Manchmal ist es schneller, einfach eine SQL-Abfrage laufen zu lassen. Beispielsweise, wenn in einer vorhandenen Tabelle zwischen zwei Importschritten bestimmte Datensätze gelöscht werden sollen.</li>
<li><strong>Hook-Funktion ausführen:</strong> Fur alles, was sich über die standardisierten Tabellenimporte nicht machen lässt, sind Hooks vorgesehen. Mit diesen (externen) Scripten können Aufgaben erledigt werden wie das Auslesen fremder Datenbanken, Dateioperationen etc.. Es wird unterschieden in Hook-Funktionen, die selbst einen Schritt darstellen und solchen, die innerhalb einer Tabellendefinition aufgerufen werden können. Passende Scripte können als eigene Contao-Erweiterungsmodule angelegt werden, da sich die Anforderungen an Importe je nach Anwendungsfall extrem unterscheiden. Zur Verdeutlichung ist ein Beispielmodul enthalten.</li>
</ul>
<p>Zur Performance: Updates erfolgen deutlich langsamer als Neuanlagen. Grundsätzlich ist es aber fast egal, wie lange die Jobs laufen, da - wie bei der Suchindex-Erstellung - in Teilschritten gearbeitet wird.</p>
<h3>Ausführung</h3>
<p>Die Jobs werden separat ausgeführt. Das kann manuell im Backend erfolgen, oder via Cronjob. Der Aufruf ist <strong>http://{IHRE-DOMAIN}/tabimporter.php?token={TOKEN}</strong>. Der benötigte Token ist in den Einstellungen des Jonbs zu finden.</p>
<p>Jeder Job wird separat finalisiert. Es empfiehlt sich also, zusammenhängende Schritte eines Imports (z.B. mehrerer CSV-Dateien in das Katalog-Modul) nicht auf mehrere Jobs zu verteilen. Andernfalls würde es im Fehlerfall zu Problemen kommen, da dann ja bereits ein Teil der Original-Tabellen ersetzt wurden, während andere nur temporär vorhanden sind.</p>
<h3>Logging und Fehlerbehebung</h3>
<p>Das Modul erstellt für jeden Lauf eines Importjobs ein Protokoll, was direkt in der Job-Übersicht aufgerufen werden kann.</p>
<p>Zu Testzwecken kann ein Job auch simuliert gestartet werden. Dies schließt spätere Fehler im Echtbetrieb  nicht aus, kann aber bei der Erstellung von Jobs nützlich sein.</p>
<p>Eingeschränkt steht eine Wiederherstellungs-Option zur verfügung. Eingeschränkt, weil nur die bearbeiteten Ziel-Tabellen wiederhergestellt werden können. Dinge, die über einen Hook verändert wurden, lassen sich hiermit nicht zurücksetzen.</p>
<h3>Fazit</h3>
<p>Im Endeffekt muss man sich halt gut überlegen, welche Schritte jeweils nötig sind, um das gewünschte Importergebnis zu erhalten. Da Datenquellen ja auch ggf. mehrfach eingelesen werden können - auch in unterschiedliche Zwischentabellen -, sind durchaus komplexe Importe in Katalogtabellen, Isotope-Shops o.ä. möglich.</p>
';

?>