require 'webrick'
include WEBrick

WebrickOptions = {
  :Port => 8000,
  :DocumentRoot => Dir::pwd,
}

s = HTTPServer.new(WebrickOptions)
trap("INT") {s.shutdown}
s.start
