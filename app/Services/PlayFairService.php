<?php

namespace App\Services;

class PlayFairService
{

    public function prepareKey($key)
    {
        $key = preg_replace('/[^A-Za-z]/', '', $key);
        $key = strtoupper($key);
        $key = str_replace('J', 'I', $key);
        $key = str_split($key);
        $key = array_unique($key);
        $key = array_values($key);
        return $key;
    }

    public function buildMatrix($key)
    {
        $alphabet = range('A', 'Z');
        $keyLength = count($key);
        $matrix = $key;
        for ($i = 0; $i < count($alphabet); $i++) {
            if (!in_array($alphabet[$i], $key)) {
                array_push($matrix, $alphabet[$i]);
            }
        }
        return array_chunk($matrix, 5);
    }

    public function findPosition($matrix, $char)
    {
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($matrix[$i][$j] == $char) {
                    return array($i, $j);
                }
            }
        }
        return null;
    }

    public function playfairEncrypt($plaintext, $key)
    {
        $key = $this->prepareKey($key);
        $matrix = $this->buildMatrix($key);
        $plaintext = preg_replace('/[^A-Za-z]/', '', $plaintext);
        $plaintext = strtoupper($plaintext);

        // Pad 'X' between repeated characters
        $textLength = strlen($plaintext);
        for ($i = 0; $i < $textLength - 1; $i += 2) {
            if ($plaintext[$i] == $plaintext[$i + 1]) {
                $plaintext = substr_replace($plaintext, 'X', $i + 1, 0);
                $textLength++;
            }
        }

        // Pad 'X' if the text length is odd
        if ($textLength % 2 != 0) {
            $plaintext .= 'X';
        }

        $ciphertext = '';
        $textLength = strlen($plaintext);
        for ($i = 0; $i < $textLength; $i += 2) {
            list($row1, $col1) = $this->findPosition($matrix, $plaintext[$i]);
            list($row2, $col2) = $this->findPosition($matrix, $plaintext[$i + 1]);

            if ($row1 == $row2) {
                $ciphertext .= $matrix[$row1][($col1 + 1) % 5];
                $ciphertext .= $matrix[$row2][($col2 + 1) % 5];
            } elseif ($col1 == $col2) {
                $ciphertext .= $matrix[($row1 + 1) % 5][$col1];
                $ciphertext .= $matrix[($row2 + 1) % 5][$col2];
            } else {
                $ciphertext .= $matrix[$row1][$col2];
                $ciphertext .= $matrix[$row2][$col1];
            }
        }

        return $ciphertext;
    }

    public function playfairDecrypt($ciphertext, $key)
    {
        $key = $this->prepareKey($key);
        $matrix = $this->buildMatrix($key);

        $plaintext = '';
        $textLength = strlen($ciphertext);
        for ($i = 0; $i < $textLength; $i += 2) {
            list($row1, $col1) = $this->findPosition($matrix, $ciphertext[$i]);
            list($row2, $col2) = $this->findPosition($matrix, $ciphertext[$i + 1]);

            if ($row1 == $row2) {
                $plaintext .= $matrix[$row1][($col1 - 1 + 5) % 5];
                $plaintext .= $matrix[$row2][($col2 - 1 + 5) % 5];
            } elseif ($col1 == $col2) {
                $plaintext .= $matrix[($row1 - 1 + 5) % 5][$col1];
                $plaintext .= $matrix[($row2 - 1 + 5) % 5][$col2];
            } else {
                $plaintext .= $matrix[$row1][$col2];
                $plaintext .= $matrix[$row2][$col1];
            }
        }

        return $plaintext;
    }
}
