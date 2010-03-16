<?php

class dcSwishHighlight
{
  public static function highlight(SwishResultWrapper $srw, $query)
  {
    $highlighted_text = "";
    $text = $srw->getDescription();

    // save the positions of the keywords
    $positions = array();

    $words = self::explode($query, $srw->getRemovedStopwords());

    // word by word...
    foreach ($words as $word)
    {
      $offset = 0;
      // ...match all occurrences
      while ($pos = stripos($text, $word, $offset))
      {
        // if the position is not already seen
        if (!self::near_position($pos, $positions))
        {
          // save a chunk of the text
          $positions[] = $pos;
          $highlighted_text .= "...".substr($text, $pos - 20, 100)."... ";
          break;
        }

        $offset = $pos + strlen($word);
      }
    }

    // highlight word by word
    foreach ($words as $word)
    {
      $word = preg_quote($word);
      $highlighted_text = preg_replace("/($word)/i", '<span class="highlight_word">\1</span>', $highlighted_text);
    }

    return $highlighted_text;
  }

  private static function near_position($position, $positions)
  {
    $near = false;

    for ($i = $position - 20; $i <= $position + 100; $i ++)
    {
      if (in_array($i, $positions))
      {
        $near = true;
        break;
      }
    }

    return $near;
  }

  /**
   * explode the query string:
   *  * words within "" remains together
   */
  private static function explode($query, $stopwords)
  {
    $words = array();
    $non_empty_words = array();

    foreach (explode("\"", $query) as $word)
    {
      $words[] = $word;
    }

    foreach ($words as $word)
    {
      if (!preg_match("/\s\w\s/", $word) && !empty($word))
      {
        $non_empty_words[] = $word;
      }
    }

    $words = array();

    foreach (explode(" ", $query) as $word)
    {
      if (!preg_match("/\"/", $word))
      {
        $words[] = $word;
      }
    }

    foreach ($words as $word)
    {
      if (!empty($word))
      {
        $non_empty_words[] = $word;
      }
    }

    // remove all stopwords
    $new_non_empty_words = array();
    for ($i = 0; $i < count($non_empty_words); $i++)
    {
      if (!in_array($non_empty_words[$i], $stopwords))
      {
        $new_non_empty_words[] = $non_empty_words[$i];
      }
    }

    return $new_non_empty_words;
  }
}
