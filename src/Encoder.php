<?php

declare(strict_types=1);

namespace ZahnenTechnik\Zrxp;


/**
 * Class Encoder
 */
class Encoder
{
    /**
     * @var array
     */
    protected array $keywordsDataTypes = [
        Keywords::SANR->value => "string",
        Keywords::SNAME->value => "string",
        Keywords::SWATER->value => "string",
        Keywords::CDASA->value => "integer",
        Keywords::CDASANAME->value => "string",
        Keywords::CCHANNEL->value => "string",
        Keywords::CCHANNELNO->value => "string",
        Keywords::CMW->value => "integer",
        Keywords::CNAME->value => "string",
        Keywords::CNR->value => "string",
        Keywords::CUNIT->value => "string",
        Keywords::REXCHANGE->value => "string",
        Keywords::RINVAL->value => "double",
        Keywords::RTIMELVL->value => "string",
        Keywords::XVLID->value => "integer",
        Keywords::TSPATH->value => "string",
        Keywords::CTAG->value => "string",
        Keywords::CTAGKEY->value => "string",
        Keywords::XTRUNCATE->value => "boolean",
        Keywords::METCODE->value => "string",
        Keywords::METERNUMBER->value => "string",
        Keywords::EDIS->value => "string",
        Keywords::TZ->value => "string",
        Keywords::ZDATE->value => "string",
        Keywords::ZRXPVERSION->value => "string",
        Keywords::ZRXPCREATOR->value => "string",
        Keywords::LAYOUT->value => "string",
        Keywords::TASKID->value => "string",
        Keywords::SOURCESYSTEM->value => "string",
        Keywords::SOURCEID->value => "string",
    ];

    protected array $layoutAttributesDataTypes = [
        LayoutAttributes::TIMESTAMP->value => "integer",
        LayoutAttributes::VALUE->value => "double",
        LayoutAttributes::PRIMARY_STATUS->value => "integer",
        LayoutAttributes::SYSTEM_STATUS->value => "string",
        LayoutAttributes::ADDITIONAL_STATUS->value => "string",
        LayoutAttributes::INTERPOLATION_TYPE->value => "double",
        LayoutAttributes::REMARK->value => "string",
        LayoutAttributes::TIMESTAMPOCCURRENCE->value => "integer",
        LayoutAttributes::OCCURENCECOUNT->value => "double",
        LayoutAttributes::MEMBER->value => "string",
        LayoutAttributes::FORECAST->value => "integer",
        LayoutAttributes::SIGNATURE->value => "double",
        LayoutAttributes::RESET_NUMBER->value => "double",
        LayoutAttributes::RESET_TIMESTAMP->value => "integer",
        LayoutAttributes::RELEASELEVEL->value => "string",
        LayoutAttributes::DISPATCH_INFO->value => "string",
    ];

    protected array $keywords = [];
    protected array $layout = [];
    const string ZRXP_MODE = "Standard";
    const string ZRXP_VERSION = "3014.03";
    const string ZRXP_CREATOR = "zrxp-php";
    protected array $errors = [];


    /**
     * Constructor for the class.
     *
     * @param array $keywords An array of keywords.
     * @param array $layout An array defining the layout.
     * @return void
     */
    public function __construct(array $keywords, array $layout)
    {
        $this->setKeywords($keywords);
        $this->setLayout($layout);
    }

    /**
     * Add a keyword to the list of keywords with the specified value.
     *
     * @param Keywords $keyword The keyword to be added.
     * @param mixed $value The value associated with the keyword.
     *
     * @return bool True if the keyword is successfully added, false otherwise.
     * @throws \Exception If the keyword is not found in the list of keywords or if the data type of the value is invalid.
     *
     */
    public function addKeyword(Keywords $keyword, mixed $value) : bool
    {
        if (array_key_exists($keyword->value, $this->keywordsDataTypes)) {
            $dataType = $this->keywordsDataTypes[$keyword->value];
            if (gettype($value) === $dataType) {
                $this->keywords[$keyword->value] = $value;
                return true;
            } else {
                throw new \Exception("Invalid data type for keyword: " . $keyword->value .", expected: " . $dataType . ", got: " . gettype($value));
            }
        } else {
            throw new \Exception("Keyword not found: " . $keyword->value);
        }

    }

    /**
     * Remove a keyword from the list of keywords.
     *
     * @param Keywords $keyword The keyword to be removed.
     *
     * @return bool True if the keyword is successfully removed, false otherwise.
     * @throws \Exception If the keyword is not found in the list of keywords.
     *
     */
    public function removeKeyword(Keywords $keyword) : bool
    {
        if (array_key_exists($keyword->value, $this->keywords)) {
            unset($this->keywords[$keyword->value]);
            return true;
        } else {
            throw new \Exception("Keyword not found: " . $keyword->value);
        }
    }

    /**
     * Sets the keywords for this object.
     *
     * @param array $keywords An array of keywords.
     * @return void
     */
    public function setKeywords(array $keywords) : void
    {
        if($this->keywords) {
            $this->keywords = [];
        }
        foreach ($keywords as $keyword => $value) {
            try {
                $this->addKeyword(Keywords::from($keyword), $value);
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }
    }

    /**
     * Sets the layout for this object.
     *
     * @param string $layout The layout to be set.
     * @return void
     */
    public function setLayout(array $layout) : void
    {
        foreach ($layout as $attribute){
            try {
                $this->addAttribute(LayoutAttributes::from($attribute));
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }
    }

    /**
     * Add an attribute to the list of attributes with the specified value.
     *
     * @param LayoutAttributes $attribute The attribute to be added.
     * @param mixed $value The value associated with the attribute.
     *
     * @return bool True if the attribute is successfully added, false otherwise.
     * @throws \Exception If the attribute is not found in the list of attributes or if the data type of the value is invalid.
     */
    public function addAttribute(LayoutAttributes $attribute) : bool
    {
        if (array_key_exists($attribute->value, $this->layoutAttributesDataTypes)) {
            $this->layout[$attribute->value] = $attribute->value;
            return true;
        } else {
            throw new \Exception("Attribute not found: " . $attribute->value);
        }
    }

    /**
     * Remove an attribute from the list of attributes.
     *
     * @param LayoutAttributes $attribute The attribute to be removed.
     *
     * @return bool True if the attribute is successfully removed, false otherwise.
     * @throws \Exception If the attribute is not found in the list of attributes.
     */
    public function removeAttribute(LayoutAttributes $attribute) : bool
    {
        if (array_key_exists($attribute->value, $this->layout)) {
            unset($this->layout[$attribute->value]);
            return true;
        } else {
            throw new \Exception("Attribute not found: " . $attribute->value);
        }
    }

    /**
     * Encodes the header in a specific format and returns it as a string.
     *
     * The encoded header is constructed using various keywords and values stored in the object.
     * The delimiter used to separate keywords and values is '|*|'.
     * Each line in the encoded header starts with the '#' symbol followed by the keyword or value.
     *
     * @return string The encoded header as a string.
     */
    public function encodeHeader() : string{
        $delimiter = '|*|';
        $keywords = '#';
        $keywords .= Keywords::ZRXPVERSION->name . self::ZRXP_VERSION . $delimiter;
        $keywords .= Keywords::ZRXPCREATOR->name . self::ZRXP_CREATOR . $delimiter;
        $keywords .= PHP_EOL;
        $keywords .= "#";
        $keywordIndex = 0;
        foreach ($this->keywords as $keyword => $value) {
            switch ($keyword) {
                case Keywords::ZRXPVERSION->value:
                case Keywords::ZRXPCREATOR->value:
                case Keywords::LAYOUT->value:
                    break;
                default:
                    $keywords .= strtoupper($keyword) . $value . $delimiter;
                    $keywordIndex++;
                    // Add a new line after every 6 keywords
                    if($keywordIndex % 6 === 0) {
                        $keywords .= PHP_EOL;
                        $keywords .= "#";
                    }
                    break;
            }
        }
        $keywords .= PHP_EOL;
        $keywords .= "#";
        $keywords .= Keywords::LAYOUT->name.'(' . implode(',', $this->layout) .')'. $delimiter;

        return $keywords;

    }

    /**
     * Encodes a row of data into a string.
     *
     * @param array $rowData An array containing the row data.
     * @return string The encoded row as a string.
     *
     * @throws \Exception If the data type of the value is invalid or if the attribute is not found in the list of attributes.
     */
    public function encodeRow(array $rowData) : string
    {
        $row = '';
        $columnIndex = 0;
        foreach ($this->layout as $attribute) {
            if($columnIndex > 0) {
                $row .= ' ';
            }
            // Check if the value type is correct
            if (array_key_exists($attribute, $rowData)) {
                $dataType = $this->layoutAttributesDataTypes[$attribute];
                if (gettype($rowData[$attribute]) !== $dataType) {
                    $this->errors[] = "Invalid data type for attribute: " . $attribute. ", expected: " . $dataType . ", got: " . gettype($rowData[$attribute]);
                    throw new \Exception("Invalid data type for attribute: " . $attribute);
                }
            } else {
                $this->errors[] = "Attribute not found: " . $attribute;
                throw new \Exception("Attribute not found: " . $attribute);
            }
            $row .= $rowData[$attribute];
            $columnIndex++;
        }
        return $row;
    }

    /**
     * Encodes the given data into a string format for further processing.
     *
     * @param array $data The data to be encoded.
     * @return void
     */
    public function encode(array $data) : string
    {
        $fileContent = $this->encodeHeader();
        // Sort data by timestamp in row ascending order
        usort($data, function($a, $b) {
            return $a[LayoutAttributes::TIMESTAMP->value] <=> $b[LayoutAttributes::TIMESTAMP->value];
        });
        $rowIndex = 0;
        foreach ($data as $row) {
            $fileContent .= PHP_EOL;
            try {
                $fileContent .= $this->encodeRow($row);
            } catch (\Exception $e) {
                $this->errors[] = "Error in row ". $rowIndex . ":". $e->getMessage();
            }
            $rowIndex++;
        }

        return $fileContent;
    }

    /**
     * Returns the errors that occurred during encoding.
     *
     * @return array The errors that occurred during encoding.
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

}