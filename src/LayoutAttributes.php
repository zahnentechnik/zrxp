<?php

namespace ZahnenTechnik\Zrxp;

enum LayoutAttributes : string
{
    case TIMESTAMP = "timestamp";
    case VALUE = "value";
    case PRIMARY_STATUS = "primary_status";
    case SYSTEM_STATUS = "system_status";
    case ADDITIONAL_STATUS = "additional_status";
    case INTERPOLATION_TYPE = "interpolation_type";
    case REMARK = "remark";
    case TIMESTAMPOCCURRENCE = "timestampoccurrence";
    case OCCURENCECOUNT = "occurencecount";
    case MEMBER = "member";
    case FORECAST = "forecast";
    case SIGNATURE = "signature";
    case RESET_NUMBER = "reset_number";
    case RESET_TIMESTAMP = "reset_timestamp";
    case RELEASELEVEL = "releaselevel";
    case DISPATCH_INFO = "dispatch_info";

}
