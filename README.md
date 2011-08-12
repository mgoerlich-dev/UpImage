upimage
======

Was ist UpImage?
----------------

UpImage ist ein kleines CLI-Tool mit folgenden Funktionen:

* Ein gegebenes Bild mit einem einfachen Befehl über die CLI auf gullipics.com
  hochladen kann

* Ein Screenshot erstellen der direkt auf gullipics.com hochgeladen wird


Vorraussetzungen:
-----------------

* PHP
* PHP-Curl
* Scrot

Wobei letzteres optional ist und durch ein beliebiges CLI-Programm zum erstellen
von Screenshots ersetzt werden kann. Dafür muss nur die Variable $creen_cmd
im Script angepasst werden ;)


Setup
-----

Als erstes holt ihr euch das Script aus dem Repo:

        $ cd /path/to/install
        $ git clone git://github.com/starflow/upimage.git

Dann müsst ihr dem Script eigentlich nurnoch Rechte zum Ausführen geben:
        
        $ cd upimage
        $ chmod +x upimage.php

Optional kann man das Script nun auch in ein Verzeichnis
innerhalb von $PATH verlinken damit es euch auch immer zur Verfügung steht:

        $ ln -s /path/to/upimage.php /usr/bin/upimage


CLI Optionen
--------------------

        $ upimage -f <file>

<file> wird auf Gullipics.com hochgeladen

        $ upimage -t | --take-shot

Ein Screenshot wird erstellt und auf Gullipics.com hochgeladen


In beiden Fällen liefert das Script bei Erfolg einen Direkt Link zum
hochgeladenen Bild, ein Thumbnail Link, und einen Delete Link um das Bild
wieder zu löschen.

Beispiel-Ausgabe:

        $ upimag -t
        Upload erfolgreich.
        Image Link:     http://s.gullipics.com/image/s/0/m/833a3d-jsbo07-y67c/img.png
        Thumbnail Link: http://s.gullipics.com/image/s/0/m/833a3d-jsbo07-y67c/img.small.png
        Delete Link:    http://www.gullipics.com/api/delete/from/image/uid/s0m-833a3d-jsbo07-y67c/....
