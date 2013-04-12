# this program to follow only English users
abort("Usage: ruby #{File.basename(__FILE__)} SPECIFIC_SCREEN_NAME") unless user = ARGV.first

require File.expand_path('../boot', __FILE__)

REGEXP_JPN = /(?:\p{Hiragana}|\p{Katakana}|[一-龠々])/

followings = Twitter.friend_ids(user)
followings.ids.each_with do |id|
  u =  Twitter.user(id)
  next if u.following == true || u.protected == true || u.lang != 'en' || u.description =~ REGEXP_JPN
  next if u.status && u.status.text =~ REGEXP_JPN
  Twitter.follow(id)
  puts u.name
end
