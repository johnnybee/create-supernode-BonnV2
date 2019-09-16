-- PowerDNS recursor: Filter AAAA records
-- Copyright (c) 2013-2019 SATOH Fumiyasu @ OSS Technology Corp., Japan
--               https://github.com/fumiyas/pdns-scripts
--               https://fumiyas.github.io/
--
-- License GPLv3+: GNU GPL version 3 or later
--
-- PowerDNS recursor 4.0+ is required

exclude_domains = {
  --newDN('google.com'),
  --newDN('microsoft.com'),
  newDN('bn.ffkbu'),
}

function postresolve(dq)
  for i, exclude_domain in ipairs(exclude_domains) do
    if dq.qname:isPartOf(exclude_domain) then
      return true
    end
  end

  local records = dq:getRecords()
  local records_new = {}

  for i, record in ipairs(records) do
    if record.type ~= pdns.AAAA then
      records_new[#records_new + 1] = record
    end
  end

  dq:setRecords(records_new)

  return true
end

