## Upgrade der Dependencies

### Abhängigkeiten updaten

unter src/Elasticsearch/Filter/Attribute/ProductProposalTextCollectionFilter.php müssen noch einige Klassen ersetzt werden! 
Die verwendeten Klassen kommen noch aus einer anderen früheren PIM Version

Bitte dazu einmal mit https://github.com/akeneo/pim-community-dev/tree/v7.0.68/src vergleichen

Ggf muss hier auch noch die Changelog studiert werden.

Bitte die tests anpassen, so dass wir wissen das es weiterhin funktioniert.