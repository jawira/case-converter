# https://github.com/markdownlint/markdownlint/blob/master/docs/creating_styles.md
all
rule 'line-length', :line_length => 80, :code_blocks => false, :tables => false
rule 'MD003', :style => "atx"
exclude_rule 'code-block-style'
exclude_rule 'ol-prefix'
