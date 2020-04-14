# -*- coding: utf-8 -*-
"""intro.ipynb

Automatically generated by Colaboratory.

Original file is located at
    https://colab.research.google.com/github/tensorflow/text/blob/master/examples/intro.ipynb

##### Copyright 2018 The TensorFlow Authors.

Licensed under the Apache License, Version 2.0 (the "License");
"""

#@title Licensed under the Apache License, Version 2.0 (the "License"); { display-mode: "form" }
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
# https://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

"""<table class="tfo-notebook-buttons" align="left">
  <td>
    <a target="_blank" href="https://www.tensorflow.org/tutorials/tensorflow_text/intro"><img src="https://www.tensorflow.org/images/tf_logo_32px.png" />View on TensorFlow.org</a>
  </td>
  <td>
    <a target="_blank" href="https://colab.research.google.com/github/tensorflow/text/blob/master/examples/intro.ipynb"><img src="https://www.tensorflow.org/images/colab_logo_32px.png" />Run in Google Colab</a>
  </td>
  <td>
    <a target="_blank" href="https://github.com/tensorflow/text/blob/master/examples/intro.ipynb"><img src="https://www.tensorflow.org/images/GitHub-Mark-32px.png" />View source on GitHub</a>
  </td>
  <td>
    <a href="https://storage.googleapis.com/tensorflow_docs/text/examples/intro.ipynb"><img src="https://www.tensorflow.org/images/download_logo_32px.png" />Download notebook</a>
  </td>
</table>

# TF.Text

## Introduction

TensorFlow Text provides a collection of text related classes and ops ready to use with TensorFlow 2.0. The library can perform the preprocessing regularly required by text-based models, and includes other features useful for sequence modeling not provided by core TensorFlow.

The benefit of using these ops in your text preprocessing is that they are done in the TensorFlow graph. You do not need to worry about tokenization in training being different than the tokenization at inference, or managing preprocessing scripts.

## Eager Execution

TensorFlow Text requires TensorFlow 2.0, and is fully compatible with eager mode and graph mode.

---

Note: On rare occassions, this import may fail looking for the TF library. Please reset the runtime and rerun the pip install below.
"""

!pip install tensorflow-text

import tensorflow as tf
import tensorflow_text as text

"""## Unicode

Most ops expect that the strings are in UTF-8. If you're using a different encoding, you can use the core tensorflow transcode op to transcode into UTF-8. You can also use the same op to coerce your string to structurally valid UTF-8 if your input could be invalid.
"""

docs = tf.constant([u'Everything not saved will be lost.'.encode('UTF-16-BE'), u'Sad☹'.encode('UTF-16-BE')])
utf8_docs = tf.strings.unicode_transcode(docs, input_encoding='UTF-16-BE', output_encoding='UTF-8')

"""## Tokenization

Tokenization is the process of breaking up a string into tokens. Commonly, these tokens are words, numbers, and/or punctuation.

The main interfaces are `Tokenizer` and `TokenizerWithOffsets` which each have a single method `tokenize` and `tokenize_with_offsets` respectively. There are multiple tokenizers available now. Each of these implement `TokenizerWithOffsets` (which extends `Tokenizer`) which includes an option for getting byte offsets into the original string. This allows the caller to know the bytes in the original string the token was created from.

All of the tokenizers return RaggedTensors with the inner-most dimension of tokens mapping to the original individual strings. As a result, the resulting shape's rank is increased by one. Please review the ragged tensor guide if you are unfamiliar with them. https://www.tensorflow.org/guide/ragged_tensors

### WhitespaceTokenizer

This is a basic tokenizer that splits UTF-8 strings on ICU defined whitespace characters (eg. space, tab, new line).
"""

tokenizer = text.WhitespaceTokenizer()
tokens = tokenizer.tokenize(['everything not saved will be lost.', u'Sad☹'.encode('UTF-8')])
print(tokens.to_list())

"""### UnicodeScriptTokenizer

This tokenizer splits UTF-8 strings based on Unicode script boundaries. The script codes used correspond to International Components for Unicode (ICU) UScriptCode values. See: http://icu-project.org/apiref/icu4c/uscript_8h.html

In practice, this is similar to the `WhitespaceTokenizer` with the most apparent difference being that it will split punctuation (USCRIPT_COMMON) from language texts (eg. USCRIPT_LATIN, USCRIPT_CYRILLIC, etc) while also separating language texts from each other.
"""

tokenizer = text.UnicodeScriptTokenizer()
tokens = tokenizer.tokenize(['everything not saved will be lost.', u'Sad☹'.encode('UTF-8')])
print(tokens.to_list())

"""### Unicode split

When tokenizing languages without whitespace to segment words, it is common to just split by character, which can be accomplished using the [unicode_split](https://www.tensorflow.org/api_docs/python/tf/strings/unicode_split) op found in core.
"""

tokens = tf.strings.unicode_split([u"仅今年前".encode('UTF-8')], 'UTF-8')
print(tokens.to_list())

"""### Offsets

When tokenizing strings, it is often desired to know where in the original string the token originated from. For this reason, each tokenizer which implements `TokenizerWithOffsets` has a *tokenize_with_offsets* method that will return the byte offsets along with the tokens. The offset_starts lists the bytes in the original string each token starts at, and the offset_limits lists the bytes where each token ends.
"""

tokenizer = text.UnicodeScriptTokenizer()
(tokens, offset_starts, offset_limits) = tokenizer.tokenize_with_offsets(['everything not saved will be lost.', u'Sad☹'.encode('UTF-8')])
print(tokens.to_list())
print(offset_starts.to_list())
print(offset_limits.to_list())

"""### TF.Data Example

Tokenizers work as expected with the tf.data API. A simple example is provided below.
"""

docs = tf.data.Dataset.from_tensor_slices([['Never tell me the odds.'], ["It's a trap!"]])
tokenizer = text.WhitespaceTokenizer()
tokenized_docs = docs.map(lambda x: tokenizer.tokenize(x))
iterator = iter(tokenized_docs)
print(next(iterator).to_list())
print(next(iterator).to_list())

"""## Other Text Ops

TF.Text packages other useful preprocessing ops. We will review a couple below.

### Wordshape

A common feature used in some natural language understanding models is to see if the text string has a certain property. For example, a sentence breaking model might contain features which check for word capitalization or if a punctuation character is at the end of a string.

Wordshape defines a variety of useful regular expression based helper functions for matching various relevant patterns in your input text. Here are a few examples.
"""

tokenizer = text.WhitespaceTokenizer()
tokens = tokenizer.tokenize(['Everything not saved will be lost.', u'Sad☹'.encode('UTF-8')])

# Is capitalized?
f1 = text.wordshape(tokens, text.WordShape.HAS_TITLE_CASE)
# Are all letters uppercased?
f2 = text.wordshape(tokens, text.WordShape.IS_UPPERCASE)
# Does the token contain punctuation?
f3 = text.wordshape(tokens, text.WordShape.HAS_SOME_PUNCT_OR_SYMBOL)
# Is the token a number?
f4 = text.wordshape(tokens, text.WordShape.IS_NUMERIC_VALUE)

print(f1.to_list())
print(f2.to_list())
print(f3.to_list())
print(f4.to_list())

"""### N-grams & Sliding Window

N-grams are sequential words given a sliding window size of *n*. When combining the tokens, there are three reduction mechanisms supported. For text, you would want to use `Reduction.STRING_JOIN` which appends the strings to each other. The default separator character is a space, but this can be changed with the string_separater argument.

The other two reduction methods are most often used with numerical values, and these are `Reduction.SUM` and `Reduction.MEAN`.
"""

tokenizer = text.WhitespaceTokenizer()
tokens = tokenizer.tokenize(['Everything not saved will be lost.', u'Sad☹'.encode('UTF-8')])

# Ngrams, in this case bi-gram (n = 2)
bigrams = text.ngrams(tokens, 2, reduction_type=text.Reduction.STRING_JOIN)

print(bigrams.to_list())