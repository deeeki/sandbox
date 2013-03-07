require 'bundler/setup'
Bundler.require(:default)
require 'tempfile'
Dotenv.load

session = GoogleDrive.login(ENV['GOOGLE_USER'], ENV['GOOGLE_PASS'])
session.files.each do |file|
  next unless file.is_a?(GoogleDrive::Spreadsheet)
  next if file.title =~ /uploaded_.+/
  ws = file.worksheets.first
  csv = Tempfile.new(file.key)
  File.write(csv, ws.rows.map{|r| r.join(',') }.uniq.join("\n"))
  session.upload_from_file(csv, "uploaded_#{file.key}.csv")
  #file.delete
end
