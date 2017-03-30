<?php

namespace gordonmurray;

class cleanImportHeadings
{

    /**
     * Given an array of "messy" strings, clean them up as best as possible
     *
     * @param $originalFieldNamesArray array
     * @return mixed array
     */
    public function cleanStringsArray($originalFieldNamesArray)
    {
        // split at uppercase letters
        $fieldNamesArray = array_map(array($this, 'splitAtUpperCase'), $originalFieldNamesArray);

        // basic clean of the field names
        $fieldNamesArray = array_map(array($this, 'basicClean'), $fieldNamesArray);

        // determine words which occur most often
        $wordsToDrop = $this->determineWordsToDrop($fieldNamesArray);

        // strip out the words from the original fields names
        return $this->removeProvidedWords($fieldNamesArray, $wordsToDrop);
    }

    /**
     * Given an array of strings, determine which words occur across several strings
     *
     * @param $fieldNamesArray
     * @return mixed
     */
    public function determineWordsToDrop($fieldNamesArray)
    {

        // create an array of counts of each word in an array like 'foo'=>5, 'bar'=>2
        $fieldNamesWordCountArray = array_count_values(explode(' ', implode(' ', $fieldNamesArray)));

        // get just the counts of each word
        $fieldNamesWordCounts = array_values($fieldNamesWordCountArray);

        // create a filtered list with only the outlier word counts
        $outlierCounts = array_unique($this->identifyOutliers($fieldNamesWordCounts));

        // using the outlier word counts, return only the words that occur a lot, the outliers
        $mostCommonWords = array_intersect($fieldNamesWordCountArray, $outlierCounts);

        // get just the words, no need for the keys
        return array_keys($mostCommonWords);
    }

    /**
     * Given an array of strings, strip out mentions of specific words provided
     *
     * @param $arrayOfStrings
     * @param $wordsToDrop
     * @return mixed
     */
    public function removeProvidedWords($arrayOfStrings, $wordsToDrop)
    {
        $array = explode(",", str_replace($wordsToDrop, "", implode(",", $arrayOfStrings)));

        $array = array_map(array($this, 'basicClean'), $array);

        return $array;
    }

    /**
     * Return filtered array of values that lie outside $mean +- $deviation
     *
     * @param $arrayOfWords
     * @param int $magnitude
     * @return array
     */
    public function identifyOutliers($arrayOfWords, $magnitude = 1)
    {
        $count = count($arrayOfWords);
        $mean = array_sum($arrayOfWords) / $count; // Calculate the mean
        $deviation = sqrt(array_sum(array_map(array($this, 'squareMinusMean'), $arrayOfWords, array_fill(0, $count, $mean))) / $count) * $magnitude; // Calculate standard deviation and times by magnitude

        return array_filter($arrayOfWords, function ($x) use ($mean, $deviation) {
            return ($x >= $mean + $deviation || $x <= $mean - $deviation);
        });
    }

    /**
     * Return the squareMinusMean
     *
     * @param $value
     * @param $mean
     * @return mixed
     */
    public function squareMinusMean($value, $mean)
    {
        return pow($value - $mean, 2);
    }

    /**
     * Perform a simple clean of a string
     *
     * @param $string
     * @return string
     */
    public function basicClean($string)
    {
        return (trim(strtolower(str_replace(array("_", "/"), " ", $string))));
    }

    /**
     * Split strings that have uppercase letters in them, like firstName
     * 
     * @param $string
     * @return mixed
     */
    public function splitAtUpperCase($string)
    {
        return preg_replace('/(?<!^)([A-Z])/', ' \\1', $string);
    }
}
