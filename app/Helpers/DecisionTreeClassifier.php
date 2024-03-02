<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class DecisionTreeClassifier
{
  protected Collection $dataFrame;
  protected array $predict;

  public function fit($dataFrame)
  {
    $this->dataFrame = $dataFrame;
  }

  /**
   * Menghitung entropi dari sebuah kolom
   */
  function calculate_entropy($probabilities)
  {
    $entropy = 0;
    foreach ($probabilities as $probability) {
      if ($probability != 0) {
        $entropy += $probability * log($probability, 2);
      }
    }
    return -$entropy;
  }

  function calculate_gain_information($parent_entropy, $child_entropies, $child_probabilities)
  {
    $gain = $parent_entropy;
    foreach ($child_entropies as $i => $child_entropy) {
      $gain -= $child_probabilities[$i] * $child_entropy;
    }
    return $gain;
  }

  /**
   * Mencari probabilitas dari sebuah kolom
   */
  function find_probabilities($feature)
  {
    $probabilities = [];
    foreach ($this->dataFrame as $data) {
      $keyword = $data[$feature];

      if (!isset($probabilities[$keyword])) {
        $probabilities[$keyword] = 1;
      } else {
        $probabilities[$keyword]++;
      }
    }

    $totalData = $this->totalDataFrame();
    foreach ($probabilities as $index => $count) {
      $probabilities[$index] = $count / $totalData;
    }

    return $probabilities;
  }

  public function totalDataFrame()
  {
    return $this->dataFrame->count();
  }

  public function predict(array $filter)
  {
    $features = array_keys($filter);
    $featureParentEntropies = [];
    $entropies = [];
    $probabilities = [];

    foreach ($features as $feature) {
      $probability = $this->find_probabilities($feature);
      $probabilities[$feature] = $probability;
      $parentEntropy = $this->calculate_entropy($probability);
      $featureParentEntropies[$feature] = $parentEntropy;

      foreach ($probability as $item => $value) {
        $entropies[$feature][$item] = $this->calculate_entropy([$value, 1 - $value]);
      }
    }

    foreach ($features as $feature) {
      $childEntropy = 0;
      $childProbability = 0;

      $childEntropy = $entropies[$feature];
      $childProbability = $probabilities[$feature];

      $gainInformation[$feature] = $this->calculate_gain_information($featureParentEntropies[$feature], $childEntropy, $childProbability);
    }

    // order descending
    arsort($gainInformation);

    $dataFrame = $this->dataFrame;

    foreach (array_keys($gainInformation) as $column) {
      $dataFrame = $dataFrame->filter(function ($data) use ($filter, $column) {
        if (is_array($filter[$column])) {
          return in_array($data[$column], $filter[$column]);
        }
        return $data->$column == $filter[$column];
      });
    }

    return $dataFrame;
  }
}
