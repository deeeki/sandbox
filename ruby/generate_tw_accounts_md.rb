str = '- [@%s](https://twitter.com/%s) <a href="https://twitter.com/%s" class="twitter-follow-button" data-show-count="false" data-size="large" data-dnt="true">Follow @%s</a>'

list = IO.read('./list').split("\n")
list.each do |a|
  puts sprintf(str, a, a, a, a)
  puts
end
