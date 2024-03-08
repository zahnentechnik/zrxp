# ZRXP Library to write ZRXP files

The data format ZRXP is a line-oriented text file format having ISO-8859-1 encoding which corresponds to ISOLATIN-1. It allows to export various information about time series values (time stamp, the value itself; the status of
a value (encoded); the status as short text. the status as long text, influences, etc.). The related column definition is
contained in the block header.
A file in ZRXP format consists of one or several segments (blocks) with each segment being divided into a basic data
header and a time series value block

Reference: [ZRXP 3.0 Reference Manual](https://prozessing.tbbm.at/zrxp/zrxp3.0_de.pdf)
